@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@php
    $currency = session()->get('currency');
@endphp
    <div class="i-card-md">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-3">

                    @if(check_permission('view_attendance') || check_permission('update_attendance') )
                        <div class="col-md-5 d-flex justify-content-start">
                            @if(check_permission('update_menu'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('update_menu'))
                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item bulk-action-btn" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endif

                        </div>
                    @endif
                    <div class="col-md-7 d-flex justify-content-md-end justify-content-start">
                        <div class="search-area">


                            <form action="{{route(Route::currentRouteName())}}" method="get">

                                <div class="date-search">
                                    <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder="{{translate('Filter by date')}}">
                                    <button type="submit" class="me-2"><i class="bi bi-search"></i></button>

                                </div>

                                <div class="form-inner  ">
                                      <input name="search" value="{{request()->search}}" type="search" placeholder="{{translate('Search by name,email,phone')}}">
                                </div>
                                <button class="i-btn btn--sm info">
                                    <i class="las la-sliders-h"></i>
                                </button>
                                <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger">
                                    <i class="las la-sync"></i>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-container position-relative">
                @include('admin.partials.loader')
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                {{translate('Emplpoyee')}}
                            </th>

                            <th scope="col">
                                {{translate('Date')}}
                            </th>

                            <th scope="col"  >
                                {{translate('Status')}}
                            </th>

                            <th scope="col"  >
                                {{translate('CLock In')}}
                            </th>

                            <th scope="col"  >
                                {{translate('CLock Out')}}
                            </th>

                            <th scope="col"  >
                                {{translate('Late')}}
                            </th>

                            <th scope="col"  >
                                {{translate('Work Hour')}}
                            </th>

                            <th scope="col"  >
                                {{translate('Over Time')}}
                            </th>

                            <th scope="col">
                                {{translate('Action')}}
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances  as $attendance)

                            <tr>

                                <td data-label="{{translate('Employee')}}">
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-sm"  src='{{imageURL(@$attendance->user->file,"profile,user",true) }}' alt="{{@$attendance->user->file->name}}">
                                        <p>	{{ @$attendance->user->name ?? translate("N/A")}}</p>
                                    </div>
                                </td>

                                <td data-label="{{translate('Date')}}">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('j M, Y')  }}
                                </td>

                                <td data-label="{{translate('Status')}}">
                                    @if ($attendance->clock_in && $attendance->clock_out)
                                    <span class="i-badge capsuled success">{{translate('Present')}}</span>
                                    @elseif ($attendance->clock_in && !$attendance->clock_out)
                                    <span class="i-badge capsuled success">{{translate('Half-Day')}}</span>
                                    @else
                                    <span class="i-badge capsuled success">{{translate('Absent')}}</span>
                                    @endif
                                </td>

                                <td data-label="{{translate('Clock In')}}">
                                    {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('g:i A') : 'N/A' }}
                                </td>

                                <td data-label="{{translate('Clock Out')}}">
                                    {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('g:i A') : 'N/A' }}
                                </td>

                                <td data-label="{{translate('Late Time')}}">
                                    <span class="i-badge capsuled {{$attendance->late_time ? "warning" : "success"}}"> {{ $attendance->late_time ? $attendance->late_time . ' minutes' : 'On Time' }} </span>
                                </td>

                                <td data-label="{{translate('Work Hour')}}">
                                    {{ $attendance->work_hour ? floor($attendance->work_hour / 60) . ' Hour' . (floor($attendance->work_hour / 60) != 1 ? 's' : '') . ' ' . ($attendance->work_hour % 60) . ' Minute' . (($attendance->work_hour % 60) != 1 ? 's' : '') : 'N/A' }}
                                </td>

                                <td data-label="{{translate('Over Time')}}">
                                    {{ $attendance->over_time ? $attendance->over_time . ' minutes' : 'N/A' }}
                                </td>


                                <td data-label="{{translate('Options')}}">
                                    <div class="table-action">
                                        @if(check_permission('update_user') ||  check_permission('delete_user'))
                                            @if(check_permission('update_user'))

                                                <button  data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="{{translate('Manage')}}" class="icon-btn info">
                                                    <i class="las la-eye"></i>
                                                </button>

                                            @endif
                                        @else
                                          {{translate('N/A')}}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border-bottom-0" colspan="8">
                                    @include('admin.partials.not_found')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="Paginations">
              {{ $attendances->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modal.delete_modal')
@endsection
@push('script-include')

  <script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
  <script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
  <script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
@endpush
@push('script-push')
<script>

</script>
@endpush






