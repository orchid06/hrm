@if($attendance)

@php
$formattedClockIn  = $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') : '--';
$formattedClockOut = $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A'): '--';
$hours = floor($attendance->late_time / 60);
$minutes = $attendance->late_time % 60;
$formattedLateTime = ($hours > 0 ? $hours . ' hour ' : '') . ($minutes > 0 ? $minutes . ' mins' : '');

$hours = floor($attendance->work_hour / 60);
$minutes = $attendance->work_hour % 60;

$formattedWorkHour = ($hours > 0 ? $hours . ' hr ' : '') . ($minutes > 0 ? $minutes . ' mins' : '') ?? '--';



$lists  =  [

            [
                            "title"  =>  translate('Clock In'),
                            "value"  =>  $formattedClockIn,
            ],

            [
                            "title"  =>  translate('Clock In Out'),
                            "value"  =>  $formattedClockOut ?? translate('N/A'),
            ],

            [
                            "title"     =>  translate('Late'),
                            "value"     =>  $formattedLateTime
            ],
            [
                            "title"     =>  translate('Work Hour'),
                            "value"     =>  $formattedWorkHour ?? translate('N/A')
            ],
            [
                            "title"     =>  translate('Note'),
                            "value"     =>  $attendance->note ?? translate('N/A')
            ],

];

@endphp

<ul class="custom-info-list list-group-flush">
    @foreach ($lists as $k => $list)

                <li>
                    <span>{{ Arr::get($list, 'title') }}:</span>
                    @php
                        $value = Arr::get($list,'value') ;
                    @endphp
                    @if(Arr::has($list,'href') && Arr::get($list,'href') )
                            <a href='{{Arr::get($list,"href")}}'>
                            {{   $value }}
                        </a>
                    @else
                        @if(Arr::has($list,'is_html'))
                            @php echo $value @endphp
                        @else
                            <span>
                                {{   $value }}
                            </span>
                        @endif
                    @endif
                </li>

    @endforeach
</ul>
@else
    @include('admin.partials.not_found',['custom_message' => "No attendance record found!!"])
@endif
