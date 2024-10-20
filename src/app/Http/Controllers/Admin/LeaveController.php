<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeaveDurationType;
use App\Enums\LeaveStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\LeaveService;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Http\Utility\SendNotification;
use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\admin\Expense;
use App\Models\admin\ExpenseCategory;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use App\Traits\Notifyable;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LeaveController extends Controller
{
    use ModelAction, Fileable, Notifyable;

    public function __construct(protected LeaveService $leaveService)
    {
        //check permissions middleware
        $this->middleware(['permissions:view_leave'])->only(['list']);
        $this->middleware(['permissions:create_leave'])->only(['store', 'create']);
        $this->middleware(['permissions:update_leave'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_leave'])->only(['destroy', 'bulk']);
    }

     /**
     * category list
     *
     * @return View
     */
    public function list(): View
    {

        return view('admin.leave.index', [

            'breadcrumbs'           =>  ['Home' => 'admin.home', 'Leaves requests' => null],
            'title'                 =>  translate('Leaves Requests'),
            'leaves'                => Leave::with('user', 'leaveType')
                                        ->orderBy('created_at', 'desc')
                                        ->year()
                                        ->month()
                                        ->date()
                                        ->day()
                                        ->user()
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all()),
            'users'                 => User::all(),
            'leaveTypes'            => LeaveType::all()
        ]);
    }

    public function edit($id)
    {


        return view('admin.leave.edit' ,[
            'title'                 =>  translate('Leave Request Details'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Leave'=> 'admin.leave.list' , 'Leave request details' => null],
            'leave'                 =>  $this->leaveService->getSpecificLeaveRequest($id)
        ]);
    }

    public function update(Request $request)
    {

        $this->leaveService->validateRequest($request);

        $userId  = $request->input('user_id');
        $leaveId = $request->input('leave_id');

        if ($this->leaveService->checkOverlappingLeave(userId: $userId, request: $request, leaveId: $leaveId)) {
            throw ValidationException::withMessages([
                'date' => 'You already have a leave request on or within the selected date range.'
            ]);
        }

        $leaveData = $this->leaveService->prepareLeaveData($request, $userId);

        Leave::findOrFail($leaveId)->update($leaveData);

        return back()->with('success', translate('Leave request updated successfully .'));
    }


    public function status(Request $request): RedirectResponse
    {
        $request->validate([
            'leave_id'      => 'required|integer|exists:leaves,id',
            'leave_status'  => 'required|string|max:255',
            'note'          => 'nullable|string|max:500',
        ]);

        $status = $request->input('leave_status');

        Leave::findOrFail($request->input('leave_id'))->update([
            'status' => $request->input('leave_status'),
            'note'   => $request->input('note')
        ]);


        return back()->with('success', translate('Leave Status Updated'));
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            "id"        => ['required',"exists:leaves,id"],
            "status"    => ['required',Rule::in([LeaveStatus::APPROVED->value,LeaveStatus::DECLINED->value])],
            "notes"     => ['required',"string",'max:255'],
        ]);

        $leave   = $this->leaveService->getSpecificLeaveRequest($request->input("id"),LeaveStatus::PENDING);

        $leave->status = $request->input('status');
        $leave->note  = $request->input('notes');
        $leave->save();

        $code = [
            "name"            => $leave->user->name,
            "status"          => Arr::get(array_flip(LeaveStatus::toArray()),$leave->status ,"Pending")
        ];

        $route      =  route("user.leave.index");

        $notifications = [

            'database_notifications' => [

                'action' => [SendNotification::class, 'database_notifications'],
                'params' => [
                   [ $leave->user, 'LEAVE_UPDATE', $code, $route ]
                ],
            ],

            'email_notifications' => [

                'action' => [SendMailJob::class, 'dispatch'],
                'params' => [
                   [$leave->user, 'LEAVE_UPDATE', $code],
                ],
            ],
            'sms_notifications' => [

                'action' => [SendSmsJob::class, 'dispatch'],
                'params' => [
                    [$leave->user, 'LEAVE_UPDATE', $code],
                ],
            ],
        ];

        $this->notify($notifications);

        return back()->with(response_status("Updated successfully"));
    }
}
