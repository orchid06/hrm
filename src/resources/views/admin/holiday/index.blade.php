@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')

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
                            {{translate('Title')}}
                        </th>

                        <th scope="col">
                            {{translate('Duration Type')}}
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
                            {{translate('Description')}}
                        </th>

                        <th scope="col">
                            {{translate('Action')}}
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($holidays as $key => $holiday)

                    <tr>

                        <td data-label="{{translate('Title')}}">
                            {{$holiday->title}}
                        </td>

                        <td data-label="{{translate('Duration Type')}}">
                            {{$holiday->holiday_duration_type}}
                        </td>

                        <td data-label="{{translate('Start Date')}}">
                            {{ \Carbon\Carbon::parse($holiday->start_date ?? $holiday->date)->format('j M, Y')}}
                        </td>

                        <td data-label="{{translate('End Date')}}">
                            {{ \Carbon\Carbon::parse($holiday->end_date ?? $holiday->date)->format('j M, Y') }}
                        </td>

                        <td data-label="{{translate('Total Days')}}">
                            {{@$holiday->total_days}}
                        </td>


                        <td data-label="{{translate('Desctiption')}}">
                            {{@$holiday->description}}
                        </td>

                        <td data-label="{{translate('Action')}}">
                            <div class="table-action">
                                @if(check_permission('delete_holiday'))
                                    <button data-bs-toggle="tooltip" data-bs-placement="top" holiday_key={{$key}} holiday="{{json_encode($holiday)}}"
                                        data-bs-title="{{translate('Edit')}}" class="edit icon-btn info">
                                        <i class="las la-edit"></i>
                                    </button>
                                @endif

                                @if(check_permission('delete_holiday'))
                                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Delete')}}" data-href="{{route('admin.holiday.destroy',$key)}}" class="delete-item icon-btn danger">
                                    <i class="las la-trash-alt"></i></a>
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
                    {{translate('Set Holiday')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.holiday.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-inner">
                                <label for="title">{{translate('Title')}} </label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="{{translate('Set a holiday title')}}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="holiday_duration_type">{{translate('Holiday Duration Type')}} <small
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
                        <label for="description">{{translate('Description')}}</label>
                        <textarea name="description" id="description" cols="30" rows="10"> </textarea>
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

<div class="modal fade modal-md" id="editHoliday" tabindex="-1" aria-labelledby="editHoliday"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Update Holiday')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.holiday.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="holiday_key">

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-inner">
                                <label for="edit_title">{{translate('Title')}} </label>
                                <input type="text" name="title" id="edit_title" class="form-control"
                                    placeholder="{{translate('Set a holiday title')}}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="edit_holiday_duration_type">{{translate('Holiday Duration Type')}} <small
                                    class="text-danger">*</small></label>
                            <select class="select2" id="edit_holiday_duration_type" name="holiday_duration_type" required>
                                <option></option>
                                @foreach(\App\Enums\LeaveDurationType::toArray() as $duration)
                                <option value="{{ $duration }}">{{ $duration }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div id="edit_single_date_picker">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="edit_date">{{translate('Date')}} </label>
                                    <input type="date" name="date" id="edit_date" class="form-control"
                                        placeholder="{{translate('Select Date')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="edit_range_date_picker" class="d-none">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="edit_start_date">{{translate('Start Date')}}</label>
                                    <input type="date" name="start_date" id="edit_start_date" class="form-control"
                                        placeholder="{{translate('Start Date')}}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="edit_end_date">{{translate('End Date')}}</label>
                                    <input type="date" name="end_date" id="edit_end_date" class="form-control"
                                        placeholder="{{translate('End Date')}}">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="form-inner">
                        <label for="edit_description">{{translate('Description')}}</label>
                        <textarea name="description" id="edit_description" cols="30" rows="10"> </textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                        {{translate("Update")}}
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
    <script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
    <script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
    <script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
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
            placeholder: "{{ translate('Select holiday duration') }}",
            dropdownParent: $("#addHoliday")
        });

    });


    $('#holiday_duration_type').on('change', function () {
        if ($(this).val() === 'Range') {
            $('#date').val('');
            $('#single_date_picker').addClass('d-none');
            $('#range_date_picker').removeClass('d-none');

        } else {
            $('#start_date').val('');
            $('#end_date').val('');
            $('#single_date_picker').removeClass('d-none');
            $('#range_date_picker').addClass('d-none');
        }
    });

    $('.edit').on('click', function () {

        var holiday     = JSON.parse($(this).attr("holiday"));
        var holidayKey  = $(this).attr("holiday_key");

        var modal = $('#editHoliday')

        modal.find('input[name="holiday_key"]').val(holidayKey)
        modal.find('#edit_title').val(holiday.title);
        modal.find('#edit_holiday_duration_type').val(holiday.holiday_duration_type).trigger('change');
        modal.find('#edit_date').val(holiday.date);
        modal.find('#edit_start_date').val(holiday.start_date);
        modal.find('#edit_end_date').val(holiday.end_date);
        modal.find('#edit_description').val(holiday.description);


        modal.find('#edit_holiday_duration_type').select2({
            placeholder: "{{translate('Select Type')}}",
            dropdownParent: modal,
        });

        modal.modal('show');
    });

    $('#edit_holiday_duration_type').on('change', function () {
        if ($(this).val() === 'Range') {
            $('#edit_date').val('');
            $('#edit_single_date_picker').addClass('d-none');
            $('#edit_range_date_picker').removeClass('d-none');

        } else {
            $('#edit_start_date').val('');
            $('#edit_end_date').val('');
            $('#edit_single_date_picker').removeClass('d-none');
            $('#edit_range_date_picker').addClass('d-none');
        }
    });



</script>
@endpush
