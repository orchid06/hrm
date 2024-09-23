<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class OfficeHourController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_office_hour'])->only(['view']);
        $this->middleware(['permissions:create_office_hour'])->only(['store']);
    }

    public function view(): View
    {
        return view('admin.office_hour.index' , [
            'title'          =>  translate('Set Office Hour'),
            'breadcrumbs'    =>   ['Home'=>'admin.home','Set Office Hour'=> null],
        ]);
    }


    public function store(Request $request)
    {

        $days =  [
            'Monday'    =>  'Monday',
            'Tuesday'   =>  'Tuesday',
            'Wednesday' =>  'Wednesday',
            'Thursday'  =>  'Thursday',
            'Friday'    =>  'Friday',
            'Saturday'  =>  'Saturday',
            'Sunday'    =>  'Sunday',
        ];

        $request->validate([
            'operating_day'   => ['nullable', 'array'],
            'operating_day.*' => ['nullable', Rule::in(array_keys($days))],
            'start_time'      => ['required', 'array'],
            'end_time'        => ['required', 'array'],

        ], [
            'end_time.*.required'   => translate('Please select end time'),
            'start_time.*.required' => translate('Please select start time'),
        ]);

        $officeHour = collect($days)->map(function (string $day, string $key) use ($request) {

            return
            [t2k($key)=>[

                'is_on'     =>  in_array($key, $request->input('operating_day', [])),
                'clock_in' =>  Arr::get($request->input('start_time', []), $key),
                'clock_out'   =>  Arr::get($request->input('end_time', []), $key),
            ]];

        })->collapse()->all();



        Setting::updateOrInsert(
            ['key'    => 'office_hour'],
            ['value'  => json_encode($officeHour)]
        );

        optimize_clear();

        return json_encode([
            'status'  =>  true,
            'message' => translate('Office Hour has been updated')
        ]);

    }

}
