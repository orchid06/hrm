<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Http\Services\SettingService;
use App\Models\admin\Expense;
use App\Models\admin\ExpenseCategory;
use App\Models\Core\Setting;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HolidayController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_holiday'])->only(['list']);
        $this->middleware(['permissions:create_holiday'])->only(['store', 'create']);
        $this->middleware(['permissions:update_holiday'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_holiday'])->only(['destroy', 'bulk']);
    }

    /**
     * category list
     *
     * @return View
     */
    public function list(): View
    {

        $month      = request()->input('month');
        $year       = request()->input('year');
        $dateRange  = request()->input('date');

        // Pass these to your filter function to filter the holidays based on the input
        $holidays = $this->filterHolidays($month, $year, $dateRange);




        return view('admin.holiday.index', [

            'breadcrumbs'           =>  ['Home' => 'admin.home', 'Holidays' => null],
            'title'                 =>  translate('Manage Holidays'),
            'holidays'              =>  $holidays
        ]);
    }




    public function filterHolidays($month = null, $year = null, $dateRange = null): Collection
    {
        // Fetch holiday settings

        $holidays = json_decode(site_settings('holidays'));

        // Filter by month and year
        if ($month || $year) {
            $holidays = $holidays->filter(function ($holiday) use ($month, $year) {
                if ($holiday['holiday_duration_type'] === 'Range') {
                    $startDate = Carbon::parse($holiday['start_date']);
                    $endDate = Carbon::parse($holiday['end_date']);

                    return (!$month || $startDate->month == $month || $endDate->month == $month)
                        && (!$year || $startDate->year == $year || $endDate->year == $year);
                } else {
                    $date = Carbon::parse($holiday['date']);
                    return (!$month || $date->month == $month)
                        && (!$year || $date->year == $year);
                }
            });
        }

        // Filter by custom date range if provided
        if ($dateRange) {
            [$startRange, $endRange] = explode(' - ', $dateRange);
            $startRange = Carbon::parse($startRange);
            $endRange = Carbon::parse($endRange);

            $holidays = $holidays->filter(function ($holiday) use ($startRange, $endRange) {
                if ($holiday['holiday_duration_type'] === 'Range') {
                    $startDate = Carbon::parse($holiday['start_date']);
                    $endDate = Carbon::parse($holiday['end_date']);

                    return ($startDate->between($startRange, $endRange) || $endDate->between($startRange, $endRange));
                } else {
                    $date = Carbon::parse($holiday['date']);
                    return $date->between($startRange, $endRange);
                }
            });
        }


        return collect($holidays)->map(function ($holiday) {
            return (object) $holiday;
        });
    }




    public function store(Request $request)
    {

        $newHoliday = $request->validate([
            'title'                 => 'required|string|max:255',
            'holiday_key'           => 'nullable|string',
            'holiday_duration_type' => 'required|string|in:Full day,Before Lunch,After Lunch,Range',
            'date'                  => 'nullable|date|required_if:holiday_duration_type,Full day,Before Lunch,After Lunch',
            'start_date'            => 'nullable|date|required_if:holiday_duration_type,Range',
            'end_date'              => 'nullable|date|required_if:holiday_duration_type,Range|after_or_equal:start_date',
            'description'           => 'nullable|string|max:255',
        ]);

        $settings = Setting::where('key', 'holidays')->first();
        $holidays = $settings ? json_decode($settings->value, true) : [];

        $key = $request->input('holiday_key');

        $newHoliday['total_days'] = $this->calculateTotalDays($request->input('holiday_duration_type'), $request);

        if($newHoliday['date'] ){
            $newHoliday['start_date'] = $newHoliday['date'];
            $newHoliday['end_date']   = $newHoliday['date'];
        }

        unset($newHoliday['date']);

        if ($key) {
            $holidays[$key]         = $newHoliday;
        } else {
            $newKey                 = t2k($request->input('title'));
            $holidays[$newKey]      = $newHoliday;
        }

        $status = translate('Holiday has been updated');

        $data = [
            'holidays' => $holidays
        ];

        (new SettingService())->updateSettings($data);


        optimize_clear();

        return back()->with('success', $status);
    }


    public function calculateTotalDays($holidayDurationType, $request): int
    {
        if ($holidayDurationType === 'Range' && $request->start_date && $request->end_date) {
            return Carbon::parse($request->end_date)->diffInDays(Carbon::parse($request->start_date)) + 1;
        }
        return 1; // Single day holiday
    }

    public function destroy($key)
    {


        $settings = Setting::where('key', 'holidays')->first();
        $holidays = json_decode($settings->value, true);


        try {
            if (isset($holidays[$key])) {
                unset($holidays[$key]);

                $settings->value = json_encode($holidays);
                $settings->save();

                optimize_clear();

                $status = ['success' => translate('Holiday deleted Successfully.')];
            } else {
                $status = ['error' => translate('Holiday not found.')];
            }
        } catch (Exception $e) {
            $status = ['error' => $e->getMessage()];
        }

        return back()->with($status);
    }
}
