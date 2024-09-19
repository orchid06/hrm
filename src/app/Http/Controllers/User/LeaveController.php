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
use Illuminate\Validation\ValidationException;

class LeaveController extends Controller
{
    protected $user;

    public function __construct()
    {


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
                'date',
                'after_or_equal:today'
            ],
            'start_date' => [
                'required_if:leave_duration_type,Range',
                'nullable',
                'date',
                'after_or_equal:today'
            ],
            'end_date' => [
                'required_if:leave_duration_type,Range',
                'nullable',
                'date',
                'after_or_equal:today'
            ],
            'note'          => 'nullable|string',
            'attachments.*' => 'mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $leaveDuration = $request->input('leave_duration');
        $userId = Auth::id();
        $startDate = null;
        $endDate = null;

        // Check for overlapping leave requests
        if ($leaveDuration === 'Range') {
            if ($request->start_date && $request->end_date) {
                $startDate = Carbon::parse($request->start_date);
                $endDate = Carbon::parse($request->end_date);

                $overlappingLeave = Leave::where('user_id', $userId)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where(function ($q) use ($startDate, $endDate) {
                            $q->whereBetween('start_date', [$startDate, $endDate])
                                ->orWhereBetween('end_date', [$startDate, $endDate])
                                ->orWhere(function ($q) use ($startDate, $endDate) {
                                    $q->where('start_date', '<=', $startDate)
                                        ->where('end_date', '>=', $endDate);
                                });
                        });
                    })->exists();
            }
        } elseif (in_array($leaveDuration, ['Full day', 'Before Lunch', 'After Lunch']) && $request->date) {
            $date = Carbon::parse($request->date);

            $overlappingLeave = Leave::where('user_id', $userId)
                ->where(function ($query) use ($date) {
                    $query->where('date', $date);
                })->exists();
        }

        if ($overlappingLeave) {
            throw ValidationException::withMessages([
                'date' => 'You already have a leave request on or within the selected date range.'
            ]);
        }


        $totalDays = $leaveDuration === 'Range' ? $endDate->diffInDays($startDate) + 1 : 1;

        Leave::create([
            'user_id'               => $userId,
            'leave_type_id'         => $request->input('leave_type_id'),
            'leave_duration_type'   => $leaveDuration,
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
