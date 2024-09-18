<?php

namespace App\Http\Controllers\user;

use App\Enums\LeaveStatus;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    protected $user;

    public function __construct(){


        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }

    public function index()
    {

        $leaves                 = Leave::where('user_id', Auth::id())
                                ->orderBy('date', 'desc')
                                ->year()
                                ->month()
                                ->date()
                                ->day()
                                ->paginate(paginateNumber())
                                ->appends(request()->all());

        $data['leave_taken']            = $leaves->count();
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

    public function store(Request $request)
    {

        $request->validate([
            'leave_type_id'         => 'required|integer|exists:leave_types,id',
            'leave_duration_type'   => 'required|string|in:Full day,Before Lunch,After Lunch,Range',
            'date' => [
                'required_if:leave_duration_type,Full day,Before Lunch,After Lunch',
                'nullable',
                'date'
            ],
            'start_date' => [
                'required_if:leave_duration_type,Range',
                'nullable',
                'date'
            ],
            'end_date' => [
                'required_if:leave_duration_type,Range',
                'nullable',
                'date'
            ],
            'note'          => 'nullable|string',
            'attachments.*' => 'mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $leaveDuration = $request->leave_duration;
        $totalDays = 0;

        if ($leaveDuration === 'Range' && $request->start_date && $request->end_date) {
            $startDate  = Carbon::parse($request->start_date);
            $endDate    = Carbon::parse($request->end_date);
            $totalDays  = $endDate->diffInDays($startDate) + 1;
        } elseif (in_array($leaveDuration, ['Full day', 'Before Lunch', 'After Lunch']) && $request->date) {
            $totalDays = 1;
        }

        Leave::create([
            'user_id'               => Auth::id(),
            'leave_type_id'         => $request->input('leave_type_id'),
            'leave_duration_type'   => $request->input('leave_duration_type'),
            'date'                  => $request->input('date'),
            'start_date'            => $request->input('start_date'),
            'end_date'              => $request->input('end_date'),
            'total_days'            => $totalDays,
            'reason'                => $request->input('reason'),
            'status'                => LeaveStatus::pending->status(),
        ]);

        return redirect()->route('user.leave.index')->with('success', translate('Leave request submitted.'));
    }
}
