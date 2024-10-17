@extends('layouts.master')

@push('style-include')
@endpush
@php
$statusClasses = [
\App\Enums\LeaveStatus::pending->status() => ['class' => 'warning', 'text' => translate('Pending')],
\App\Enums\LeaveStatus::approved->status() => ['class' => 'success', 'text' => translate('Approved')],
\App\Enums\LeaveStatus::declined->status() => ['class' => 'danger', 'text' => translate('Declined')],
];
@endphp
@section('content')
{{-- Cards --}}
<div class="row mb-3 g-3">
    <div class="col">

        <div class="row g-3 mb-3">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="i-card-sm style-2 primary">
                    <div class="card-info">
                        <h3>
                            {{Arr::get($data,"leave_taken",0)}}
                        </h3>
                        <h5 class="title">
                            {{translate("Leave Taken")}}
                        </h5>

                    </div>
                    <div class="d-flex flex-column align-items-end gap-4">
                        <div class="icon">
                            <i class="las la-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


</div>
{{-- Table --}}
<div class="i-card-md">
    <div class="card-header">

    </div>
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <div class="col-md-4 d-flex justify-content-start">
                    <div class="action">
                        <a href="{{route('user.leave.request')}}">
                            <button  class="i-btn btn--sm success">
                                <i class="las la-plus me-1"></i> {{translate('Request Leave')}}
                            </button>
                        </a>

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
                                    <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' :''}}>
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
                            {{translate('Start Date')}}
                        </th>

                        <th scope="col">
                            {{translate('End Date')}}
                        </th>

                        <th scope="col">
                            {{translate('Duraiton')}}
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
                    @forelse($leaves as $leave)

                    <tr>

                        <td data-label="{{translate('Type')}}">
                            {{$leave->leaveType->name}}
                        </td>

                        <td data-label="{{translate('Start Date')}}">
                            {{ \Carbon\Carbon::parse($leave->start_date ?? $leave->date)->format('j M, Y')}}
                        </td>

                        <td data-label="{{translate('End Date')}}">
                            {{ \Carbon\Carbon::parse($leave->end_date ?? $leave->date)->format('j M, Y') }}
                        </td>

                        <td data-label="{{translate('Total Days')}}">
                            {{$leave->total_days== '1' ? $leave->leave_duration_type : $leave->total_days}}
                        </td>

                        <td data-label="{{translate('Status')}}">
                            @php
                            $status = $statusClasses[$leave->status] ?? ['class' => 'secondary', 'text' =>translate('Unknown')];
                            @endphp

                            <span class="i-badge capsuled {{ $status['class'] }}">{{ $status['text'] }}</span>
                            @if($leave->note)
                            <button class=" note i-badge capsuled info" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="{{translate('View note')}}"
                                    leave="{{$leave}}">

                                 <i class="las la-info"></i>
                            </button>
                            @endif
                        </td>


                        <td data-label="{{translate('Note')}}">
                            <div class="table-action">

                                <button data-bs-toggle="tooltip" data-bs-placement="top" leave="{{$leave}}"
                                    data-bs-title="{{translate('View details')}}" class="viewDetails icon-btn info">
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
            {{ $leaves->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')
@include('modal.delete_modal')

<div class="modal fade modal-md" id="leaveRequestModal" tabindex="-1" aria-labelledby="leaveRequestModal"
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

                    <div class="row">

                        <div class="col-12">
                            <div class="form-inner">
                                <label for="leave_type_id">{{translate('Leave Type')}} <small
                                        class="text-danger">*</small></label>
                                <select name="leave_type_id" id="leave_type_id" class=".select2" required>
                                    <option value="">{{translate('Select Leave Type')}}</option>
                                    @foreach($leaveTypes as $leaveType);

                                    <option value="{{ $leaveType->id }}">
                                        {{ $leaveType->name }}
                                        ({{ $leaveType->is_paid == \App\Enums\StatusEnum::true->status() ?
                                        translate('Paid') : translate('Unpaid') }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="leave_duration_type">{{translate('Leave Duration Type')}} <small
                                    class="text-danger">*</small></label>
                            <select class="select2" id="leave_duration_type" name="leave_duration_type" required>
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

<div class="modal fade modal-md" id="noteModal" tabindex="-1" aria-labelledby="noteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Note')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-inner">

                    <textarea disabled name="note" id="note" cols="30" rows="10"> </textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-md" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('View Leave Details')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-6">
                        <div class="form-inner">
                            <label for="view_leave_type_id">{{translate('Leave Type')}} </label>
                            <select disabled name="leave_type_id" id="view_leave_type_id" class=".select2" required>
                                <option value="">{{translate('Select Leave Type')}}</option>
                                @foreach($leaveTypes as $leaveType);

                                <option value="{{ $leaveType->id }}">
                                    {{ $leaveType->name }}
                                    ({{ $leaveType->is_paid == \App\Enums\StatusEnum::true->status() ?
                                    translate('Paid') : translate('Unpaid') }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="view_leave_duration_type">{{translate('Leave Duration Type')}} </label>
                        <select disabled class="select2" id="view_leave_duration_type" name="leave_duration_type" required>
                            <option></option>
                            @foreach(\App\Enums\LeaveDurationType::toArray() as $duration)
                            <option value="{{ $duration }}">{{ $duration }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>


                <div id="view_single_date_picker">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-inner">
                                <label for="view_date">{{translate('Date')}} </label>
                                <input disabled type="date" name="date" id="view_date" class="form-control"
                                    placeholder="{{translate('Select Date')}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="view_range_date_picker" class="d-none">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-inner">
                                <label for="view_start_date">{{translate('Start Date')}}</label>
                                <input disabled type="date" name="start_date" id="view_start_date" class="form-control"
                                    placeholder="{{translate('Start Date')}}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-inner">
                                <label for="view_end_date">{{translate('End Date')}}</label>
                                <input disabled type="date" name="end_date" id="view_end_date" class="form-control"
                                    placeholder="{{translate('End Date')}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-inner">
                    <label for="reason">{{translate('Reason')}}</label>
                    <textarea disabled name="reason" id="reason" cols="30" rows="10"> </textarea>
                </div>

                <div class="form-inner">
                    <label for="view_note">{{translate('Note')}}</label>
                    <textarea disabled name="note" id="view_note" cols="30" rows="10"> </textarea>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script-include')
<script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
<script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
@endpush

@push('script-push')
<script>
    "use strict"
    $('.select2').each(function () {
        $(this).select2({
            placeholder: $(this).attr('placeholder')
        });
    });

    $('#leave_duration_type').on('change', function () {
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


    $('.note').on('click', function () {
        var leave = JSON.parse($(this).attr("leave"));
        var modal = $('#noteModal')

        modal.find('textarea[name="note"]').val(leave.note)
        modal.modal('show');
    });

    $('.viewDetails').on('click', function () {
        var leave = JSON.parse($(this).attr("leave"));
        var modal = $('#viewDetailsModal')

        modal.find('#view_leave_type_id').select2({
            placeholder: "{{translate('Select Leave Type')}}",
            dropdownParent: modal,
        });

        modal.find('#view_leave_duration_type').select2({
            placeholder: "{{translate('Select Leave Duration Status')}}",
            dropdownParent: modal,
        });

        modal.find('select[name="leave_type_id"]').val(leave.leave_type_id).trigger('change');
        modal.find('select[name="leave_duration_type"]').val(leave.leave_duration_type).trigger('change');
        modal.find('input[name="date"]').val(leave.date);
        modal.find('input[name="start_date"]').val(leave.start_date);
        modal.find('input[name="end_date"]').val(leave.end_date);
        modal.find('textarea[name="reason"]').val(leave.reason);
        modal.find('textarea[name="note"]').val(leave.note)
        modal.modal('show');
    });

    $('#view_leave_duration_type').on('change', function () {
        if ($(this).val() === 'Range') {
            $('#view_date').val('');
            $('#view_single_date_picker').addClass('d-none');
            $('#view_range_date_picker').removeClass('d-none');

        } else {
            $('#view_start_date').val('');
            $('#view_end_date').val('');
            $('#view_single_date_picker').removeClass('d-none');
            $('#view_range_date_picker').addClass('d-none');
        }
    });

</script>
@endpush
