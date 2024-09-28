<?php

namespace App\Enums;

enum AttendanceStatus : string
{
    case INVALID  = "-1";
    case HOLIDAY    = '0';
    case DAYOFF     = '1';
    case PRESENT    = '2';
    case HALF_DAY   = '3';
    case LATE       = '4';
    case ABSENT     = '5';
    case ON_LEAVE   = '6';
    case EMPLOYEE_HOLIDAY = '7';

    // Returns the numeric status value
    public function status(): string
    {
        return match($this)
        {
            self::HOLIDAY          => '0',
            self::DAYOFF           => '1',
            self::PRESENT          => '2',
            self::HALF_DAY         => '3',
            self::LATE             => '4',
            self::ABSENT           => '5',
            self::ON_LEAVE         => '6',
            self::EMPLOYEE_HOLIDAY => '7',
            self::INVALID          => '-1',
        };
    }

    // Returns a human-readable label for the status
    public function statusLabel(): string
    {
        return match($this)
        {
            self::HOLIDAY          => 'Holiday',
            self::DAYOFF           => 'Day Off',
            self::PRESENT          => 'Present',
            self::HALF_DAY         => 'Half Day',
            self::LATE             => 'Late',
            self::ABSENT           => 'Absent',
            self::ON_LEAVE         => 'On Leave',
            self::EMPLOYEE_HOLIDAY => 'Employee Holiday',
            self::INVALID          => 'Invalid Status',
        };
    }

    public function getIcon(): string
    {
        return match($this)
        {
            self::HOLIDAY          => 'info',
            self::DAYOFF           => 'primary',
            self::PRESENT          => 'success',
            self::HALF_DAY         => 'warning',
            self::LATE             => 'danger',
            self::ABSENT           => 'danger',
            self::ON_LEAVE         => 'warning',
            self::EMPLOYEE_HOLIDAY => 'info',
            self::INVALID          => 'secondary',
        };
    }

    // Returns a badge class to be used in the UI (for example, for status indicators)
    public function badgeClass(): string
    {
        return match($this)
        {
            self::HOLIDAY          => 'info',
            self::DAYOFF           => 'primary',
            self::PRESENT          => 'success',
            self::HALF_DAY         => 'warning',
            self::LATE             => 'danger',
            self::ABSENT           => 'danger',
            self::ON_LEAVE         => 'warning',
            self::EMPLOYEE_HOLIDAY => 'info',
            self::INVALID          => 'secondary',
        };
    }

    // Converts the enum into an associative array of status labels and values
    public static function toArray(): array
    {
        return [
            'Holiday'          => self::HOLIDAY->status(),
            'Day Off'          => self::DAYOFF->status(),
            'Present'          => self::PRESENT->status(),
            'Half Day'         => self::HALF_DAY->status(),
            'Late'             => self::LATE->status(),
            'Absent'           => self::ABSENT->status(),
            'On Leave'         => self::ON_LEAVE->status(),
            'Employee Holiday' => self::EMPLOYEE_HOLIDAY->status(),
            'Invalid Status'   => self::INVALID->status(),
        ];
    }
}

