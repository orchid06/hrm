<?php

namespace App\Http\Controllers\User;

use App\Enums\LeaveStatus;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\LeaveService;
use App\Models\Core\File;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Traits\Fileable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LeaveController extends Controller
{
    use Fileable;
    protected $user;

    public function __construct(protected LeaveService $leaveService)
    {

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }

    public function index(): View
    {

        $leaves                         = Leave::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->year()
            ->month()
            ->date()
            ->day()
            ->paginate(paginateNumber())
            ->appends(request()->all());

        $data['leave_taken']            = $leaves->where('status', LeaveStatus::APPROVED->status())->sum('total_days');
        $data['total_paid_leave']       = site_settings('total_paid_leave');
        $data['remaining_paid_leave']   = max(0, $data['total_paid_leave'] - $data['leave_taken']);


        return view('user.leave.index', [
            'breadcrumbs'           => ['Home' => 'user.home', 'Leaves' => null],
            'title'                 => translate('Leave'),
            'leaves'                => $leaves,
            'leaveTypes'            => LeaveType::all(),
            'data'                  => $data
        ]);
    }

    public function requestLeave()
    {

        return view('user.leave.requestLeave', [
            'breadcrumbs'           => ['Home' => 'user.home', 'Leaves' => 'user.leave.index', 'Request Leave' => null],
            'title'                 => translate('Request Leave'),
            'leaveTypes'            => LeaveType::all(),
        ]);
    }

    public function storeOrUpdate(Request $request): RedirectResponse
    {

        $leaveId = $request->input('id') ?? null;

        $this->leaveService->validateRequest(request: $request);

        $userId = Auth::id();

        if ($this->leaveService->checkOverlappingLeave(userId: $userId, request: $request, leaveId: $leaveId)) {
            throw ValidationException::withMessages(messages: [
                'date' => 'You already have a leave request on or within the selected date range.'
            ]);
        }


        $leaveData = $this->leaveService->prepareLeaveData(request: $request, userId: $userId);

        $leaveData['total_days'] = $this->leaveService->calculateTotalDays($request->input('leave_duration_type'), $request);

        $leaveType = LeaveType::findOrFail($request->input('leave_type_id'));

        if ($leaveId = $request->input('id')) {
            // Update the existing leave record
            $leave = Leave::findOrFail($leaveId);
            $leave->update($leaveData);
        } else {
            // Create a new leave record
            $leave = Leave::create($leaveData);
        }

        if ($leaveType->custom_inputs) {

            return redirect()->route('user.leave.request.customInput',  $leave->id);
        } else {


            return redirect()->route('user.leave.index')->with('success', translate('Leave request submitted.'));
        }
    }

    public function cusotmInputForm($id)
    {

        $leave = Leave::findOrFail($id);



        return view('user.leave.custom_input', [
            'breadcrumbs'           => ['Home' => 'user.home', 'Leaves' => 'user.leave.index', 'Request Leave' => 'user.leave.request', 'Custom Inputs' => null],
            'title'                 => translate('Custom Inputs'),
            'leave'                 => $leave
        ]);
    }

    public function cusotmInputStore(Request $request)
    {
        $leaveRequestData = $request->input('leave_request_data');

        $leave = Leave::findOrFail($request->input('id'));

        $leave->update([
            'leave_request_data' => (Arr::except($leaveRequestData, ['files']))
        ]);

        if (isset($leaveRequestData['files'])) {
            foreach ($leaveRequestData['files'] as $key => $file) {
                $response = $this->storeFile(
                    file: $file,
                    location: config("settings")['file_path']['leave_request_data']['path'],
                );

                if (isset($response['status'])) {
                    $fileRecord = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => $key,
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);


                    $leave->file()->save($fileRecord);
                }
            }
        }

        return redirect()->route('user.leave.index')->with('success', translate('Leave request submitted.'));
    }

    public function edit($id)
    {
        return view('user.leave.editRequest', [
            'breadcrumbs'           => ['Home' => 'user.home', 'Leaves' => 'user.leave.index', 'Request Leave' => null],
            'title'                 => translate('Request Leave'),
            'leaveTypes'            => LeaveType::all(),
            'leave'                 => Leave::findOrFail($id)
        ]);
    }

    public function details($id)
    {
        return view('user.leave.details', [
            'breadcrumbs'           => ['Home' => 'user.home', 'Leaves' => 'user.leave.index', 'Request Details' => null],
            'title'                 => translate('Leave Request Details '),
            'leaveTypes'            => LeaveType::all(),
            'leave'                 => Leave::findOrFail($id)
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $leave = Leave::findOrFail($id);


        if ($leave->status === LeaveStatus::APPROVED->status()) {
            return back()->withErrors(['error' => 'You cannot delete an approved leave request.']);
        }

        $leave->delete();

        return back()->with(response_status('Leave request deleted successfully'));
    }
}
