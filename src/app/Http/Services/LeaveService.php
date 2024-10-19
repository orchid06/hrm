<?php

namespace App\Http\Services;

use App\Enums\LeaveStatus;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class LeaveService
{
    public function validateRequest($request): mixed
    {
        return $request->validate([
            'leave_type_id'         => 'required|integer|exists:leave_types,id',
            'leave_duration_type'   => 'required|string|in:Full day,Before Lunch,After Lunch,Range',
            'date'                  => 'required_if:leave_duration_type,Full day,Before Lunch,After Lunch|nullable|date',
            'start_date'            => 'required_if:leave_duration_type,Range|nullable|date',
            'end_date'              => 'required_if:leave_duration_type,Range|nullable|date',
            'note'                  => 'nullable|string',
            'attachments.*'         => 'mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
    }

    public function checkOverlappingLeave($userId, $request, $leaveId = null): bool
    {
        return $request->input('leave_duration_type') === 'Range'
            ? $this->checkRangeOverlap(userId: $userId, startDate: $request->start_date, endDate: $request->end_date, leaveId: $leaveId)
            : $this->checkSingleDayOverlap(userId: $userId, date: $request->date, leaveId: $leaveId);
    }

    private function checkRangeOverlap($userId, $startDate, $endDate, $leaveId = null): bool
    {
        if (!$startDate || !$endDate) return false;

        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        return Leave::where('user_id', $userId)
            ->when($leaveId, function ($query) use ($leaveId) {
                // Exclude the current leave being updated
                $query->where('id', '!=', $leaveId);
            })
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();
    }

    private function checkSingleDayOverlap($userId, $date, $leaveId = null): bool
    {
        if (!$date) return false;

        $date = Carbon::parse($date);

        return Leave::where('user_id', $userId)
            ->when($leaveId, function ($query) use ($leaveId) {
                // Exclude the current leave being updated
                $query->where('id', '!=', $leaveId);
            })
            ->where(function ($query) use ($date) {
                $query->where('start_date', '<=', $date)
                      ->where('end_date', '>=', $date);
            })
            ->exists();
    }


    public function calculateTotalDays($leaveDurationType, $request): int
    {
        if ($leaveDurationType === 'Range' && $request->start_date && $request->end_date) {
            return Carbon::parse($request->end_date)->diffInDays(Carbon::parse($request->start_date)) + 1;
        }
        return 1; // Single day leave
    }

    public function prepareLeaveData($request, $userId): array
    {
        return [
            'user_id'               => $userId,
            'leave_type_id'         => $request->input('leave_type_id'),
            'leave_duration_type'   => $request->input('leave_duration_type'),
            'start_date'            => $request->input('start_date') ??  $request->input('date'),
            'end_date'              => $request->input('end_date') ?? $request->input('date'),
            'reason'                => $request->input('reason'),
            'status'                => LeaveStatus::pending->status(),
        ];
    }
}
