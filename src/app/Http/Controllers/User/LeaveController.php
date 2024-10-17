<?php

namespace App\Http\Controllers\User;

use App\Enums\LeaveStatus;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\LeaveService;
use App\Models\Leave;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LeaveController extends Controller
{
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
            ->orderBy('date', 'desc')
            ->year()
            ->month()
            ->date()
            ->day()
            ->paginate(paginateNumber())
            ->appends(request()->all());

        $data['leave_taken']            = $leaves->where('status', LeaveStatus::approved->status())->sum('total_days');
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
            'breadcrumbs'           => ['Home' => 'user.home', 'Leaves' => 'user.leave.index' , 'Request Leave' => null],
            'title'                 => translate('Request Leave'),
            'leaveTypes'            => LeaveType::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $this->leaveService->validateRequest(request: $request);

        $userId = Auth::id();

        if ($this->leaveService->checkOverlappingLeave(userId: $userId, request: $request)) {
            throw ValidationException::withMessages(messages: [
                'date' => 'You already have a leave request on or within the selected date range.'
            ]);
        }


        $leaveData = $this->leaveService->prepareLeaveData(request: $request, userId: $userId);

        $leaveData['total_days'] = $this->leaveService->calculateTotalDays($request->input('leave_duration_type'), $request);

        Leave::create($leaveData);

        return redirect()->route('user.leave.index')->with('success', translate('Leave request submitted.'));
    }
}
