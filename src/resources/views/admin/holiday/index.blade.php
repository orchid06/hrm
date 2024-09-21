@extends('admin.layouts.master')
@section('content')
@php
$holidays = site_settings('holidays') ?? [];
@endphp
<div class="i-card-md">
    <div class="card-header">

    </div>
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <div class="col-md-4 d-flex justify-content-start">
                    <div class="action">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addHoliday"
                            class="i-btn btn--sm success">
                            <i class="las la-plus me-1"></i> {{translate('Add holiday')}}
                        </button>
                    </div>
                </div>

                <div class="col-md-8 d-flex justify-content-md-end justify-content-start">

                    <div class="search-area">


                        <form action="{{route(Route::currentRouteName())}}" method="get">

                            <div class="form-inner">
                                <select name="month" class="select2" id="month"
                                    placeholder="{{translate('Select a month')}}">
                                    <option value="">{{translate('Month')}}</option>
                                    @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' :''
                                        }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-inner">
                                <select name="year" class="select2" id="year"
                                    placeholder="{{translate('Select a year')}}">
                                    <option value="">{{translate('Select a Year')}}</option>
                                    @foreach(range(date('Y') - 5, date('Y')) as $year)
                                    <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' :
                                        ''}}>
                                        {{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="date-search">
                                <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"
                                    placeholder="{{translate('Filter by date')}}">
                                <button type="submit" class="me-2"><i class="bi bi-search"></i></button>

                            </div>


                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>
                            <a href="{{route(Route::currentRouteName())}}" class="i-btn btn--sm danger">
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
                            {{translate('Type')}}
                        </th>

                        <th scope="col">
                            {{translate('Reason')}}
                        </th>

                        <th scope="col">
                            {{translate('Start Date')}}
                        </th>

                        <th scope="col">
                            {{translate('End Date')}}
                        </th>

                        <th scope="col">
                            {{translate('Days')}}
                        </th>

                        <th scope="col">
                            {{translate('Status')}}
                        </th>

                        <th scope="col">
                            {{translate('Note')}}
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($holidays as $holiday)

                    <tr>

                        <td data-label="{{translate('Type')}}">
                            {{$holiday->holidayType->name}}
                        </td>

                        <td data-label="{{translate('Reason')}}">
                            {{$holiday->reason ?? "N/A"}}
                        </td>

                        <td data-label="{{translate('Start Date')}}">
                            {{ \Carbon\Carbon::parse($holiday->start_date ?? $holiday->date)->format('j M, Y')}}
                        </td>

                        <td data-label="{{translate('End Date')}}">
                            {{ \Carbon\Carbon::parse($holiday->end_date ?? $holiday->date)->format('j M, Y') }}
                        </td>

                        <td data-label="{{translate('Total Days')}}">
                            {{$holiday->total_days== '1' ? $holiday->holiday_duration_type : $holiday->total_days}}
                        </td>

                        <td data-label="{{translate('Status')}}">
                            @php
                            $status = $statusClasses[$holiday->status] ?? ['class' => 'secondary', 'text' =>
                            translate('Unknown')];
                            @endphp

                            <span class="i-badge capsuled {{ $status['class'] }}">{{ $status['text'] }}</span>
                        </td>


                        <td data-label="{{translate('Note')}}">
                            <div class="table-action">

                                <button data-bs-toggle="tooltip" data-bs-placement="top" holiday="{{$holiday}}"
                                    data-bs-title="{{translate('View note')}}" class="edit icon-btn info">
                                    <i class="las la-edit"></i>
                                </button>

                                <button data-bs-toggle="tooltip" data-bs-placement="top" holiday="{{$holiday}}"
                                    data-bs-title="{{translate('View note')}}" class="note icon-btn info">
                                    <i class="las la-eye"></i>
                                </button>

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

        </div>
    </div>
</div>

@endsection

@section('modal')

<div class="modal fade modal-md" id="addHoliday" tabindex="-1" aria-labelledby="addHoliday"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Leave Request')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('user.leave.request')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="holiday_duration_type">{{translate('Leave Duration Type')}} <small
                                    class="text-danger">*</small></label>
                            <select class="select2" id="holiday_duration_type" name="holiday_duration_type" required>
                                <option></option>
                                @foreach(\App\Enums\LeaveDurationType::toArray() as $duration)
                                <option value="{{ $duration }}">{{ $duration }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div id="single_date_picker">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="date">{{translate('Date')}} </label>
                                    <input type="date" name="date" id="date" class="form-control"
                                        placeholder="{{translate('Select Date')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="range_date_picker" class="d-none">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="start_date">{{translate('Start Date')}}</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        placeholder="{{translate('Start Date')}}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="end_date">{{translate('End Date')}}</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        placeholder="{{translate('End Date')}}">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="form-inner">
                        <label for="reason">{{translate('Reason')}}</label>
                        <textarea name="reason" id="reason" cols="30" rows="10"> </textarea>
                    </div>

                    <div class="form-inner">
                        <label for="attachments">{{translate('Attachments')}}</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                        {{translate("Submit")}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@include('modal.delete_modal')
@include('modal.bulk_modal')
@endsection

@push('script-include')

@endpush

@push('script-push')
<script>
    "user strict"

    $('.select2').each(function () {
        $(this).select2({
            placeholder: $(this).attr('placeholder')
        });
    });

    $('#addHoliday').on('shown.bs.modal', function () {


        $("#holiday_duration_type").select2({
            placeholder: "{{ translate('Select leave duration') }}",
            dropdownParent: $("#addHoliday")
        });

    });

    $('#holiday_duration_type').on('change', function () {
        if ($(this).val() === 'Range') {

            $('#single_date_picker').addClass('d-none');
            $('#range_date_picker').removeClass('d-none');
        } else {

            $('#single_date_picker').removeClass('d-none');
            $('#range_date_picker').addClass('d-none');
        }
    });



</script>
@endpush
