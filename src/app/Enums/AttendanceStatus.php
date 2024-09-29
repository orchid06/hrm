<?php

namespace App\Enums;

enum AttendanceStatus : string
{
    case INVALID  = '-1';
    case OFFICE_HOLIDAY  = "0";
    case DAYOFF     = '1';
    case PRESENT    = '2';
    case HALF_DAY   = '3';
    case LATE       = '4';
    case ABSENT     = '5';
    case ON_LEAVE   = '6';
    case EMPLOYEE_HOLIDAY = '7';
    case PUBLIC_HOLIDAY = '8';

    case CLOCKED_IN     = '9';

    // Returns the numeric status value
    public function status(): string
    {
        return match($this)
        {
            self::OFFICE_HOLIDAY   => "0",
            self::DAYOFF           => '1',
            self::PRESENT          => '2',
            self::HALF_DAY         => '3',
            self::LATE             => '4',
            self::ABSENT           => '5',
            self::ON_LEAVE         => '6',
            self::EMPLOYEE_HOLIDAY => '7',
            self::PUBLIC_HOLIDAY   => '8',
            self::INVALID          => '-1',
            self::CLOCKED_IN       => '9'
        };
    }

    // Returns a human-readable label for the status
    public function statusLabel(): string
    {
        return match($this)
        {
            self::OFFICE_HOLIDAY   => 'Office Holiday',
            self::DAYOFF           => 'Day Off',
            self::PRESENT          => 'Present',
            self::HALF_DAY         => 'Half Day',
            self::LATE             => 'Late',
            self::ABSENT           => 'Absent',
            self::ON_LEAVE         => 'On Leave',
            self::EMPLOYEE_HOLIDAY => 'Employee Holiday',
            self::PUBLIC_HOLIDAY   => 'Public Holiday',
            self::INVALID          => 'Invalid',
            self::CLOCKED_IN       => 'Clocked In'
        };
    }

    public function getIcon(): string
    {
        return match($this)
        {
            self::OFFICE_HOLIDAY   => 'bi bi-star-fill',
            self::DAYOFF           => 'bi bi-calendar-event-fill',
            self::PRESENT          => 'bi bi-check-all',
            self::HALF_DAY         => 'bi bi-star-half',
            self::LATE             => 'bi bi-clock-history',
            self::ABSENT           => 'bi bi-x-lg',
            self::ON_LEAVE         => 'bi bi-airplane-fill',
            self::EMPLOYEE_HOLIDAY => 'bi bi-star-fill',
            self::PUBLIC_HOLIDAY   => 'bi bi-calendar4-range',
            self::INVALID          => 'bi bi-dash',
            self::CLOCKED_IN       => 'bi bi-clock'
        };
    }

    // Returns a badge class to be used in the UI (for example, for status indicators)
    public function badgeClass(): string
    {
        return match($this)
        {
            self::OFFICE_HOLIDAY   => 'warning',
            self::DAYOFF           => 'primary',
            self::PRESENT          => 'success',
            self::HALF_DAY         => 'warning',
            self::LATE             => 'danger',
            self::ABSENT           => 'danger',
            self::ON_LEAVE         => 'info',
            self::EMPLOYEE_HOLIDAY => 'info',
            self::PUBLIC_HOLIDAY   => 'success',
            self::INVALID          => 'secondary',
            self::CLOCKED_IN       => 'warning'
        };
    }

    // Converts the enum into an associative array of status labels and values
    public static function toArray(): array
    {
        return [
            'Office Holiday'   => self::OFFICE_HOLIDAY->status(),
            'Day Off'          => self::DAYOFF->status(),
            'Present'          => self::PRESENT->status(),
            'Half Day'         => self::HALF_DAY->status(),
            'Late'             => self::LATE->status(),
            'Absent'           => self::ABSENT->status(),
            'On Leave'         => self::ON_LEAVE->status(),
            'Employee Holiday' => self::EMPLOYEE_HOLIDAY->status(),
            'Public Holiday'   => self::PUBLIC_HOLIDAY->status(),
            'Invalid Status'   => self::INVALID->status(),
            'Clocked In'       => self::CLOCKED_IN->status()
        ];
    }
}
