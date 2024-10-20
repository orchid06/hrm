@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@php
        $statusClasses = [
                        \App\Enums\LeaveStatus::PENDING->status() => ['class' => 'warning', 'text' => translate('Pending')],
                        \App\Enums\LeaveStatus::APPROVED->status() => ['class' => 'success', 'text' => translate('Approved')],
                        \App\Enums\LeaveStatus::DECLINED->status() => ['class' => 'danger', 'text' => translate('Declined')],
                    ];
@endphp
<div class="i-card-md">
    <div class="card-header">

    </div>
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <div class="col-md-4 d-flex justify-content-start">
                    <div class="action">
                        <a href="{{route('admin.leave_type.list')}}" type="button" class="i-btn btn--sm primary">
                            <i class="las la-cogs fs-15"></i> {{translate('Configure Leave Type')}}
                        </a>
                    </div>
                </div>

                <div class="col-md-8 d-flex justify-content-md-end justify-content-start">

                    <div class="search-area">


                        <form action="{{route(Route::currentRouteName())}}" method="get">

                            <div class="form-inner">
                                <select name="user_id" class="select2" id="user_id"
                                    placeholder="{{translate('Select a User')}}">
                                    <option value="">{{translate('User')}}</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request()->input('user_id') == $user->id ?
                                        'selected' :'' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

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
                            {{translate('User')}}
                        </th>

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
                            {{translate('Duration')}}
                        </th>

                        <th scope="col">
                            {{translate('Status')}}
                        </th>

                        <th scope="col">
                            {{translate('Action')}}
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)

                    <tr>

                        <td data-label="{{translate('User')}}">
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <img class="rounded-circle avatar-sm"
                                    src='{{imageURL($leave->user->file,"profile,user",true) }}'
                                    alt="{{@$leave->user->file->name}}">
                                <p> {{ $leave->user->name ?? translate("N/A")}}</p>
                            </div>
                        </td>


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
                            $status = $statusClasses[$leave->status] ?? ['class' => 'secondary', 'text' =>
                            translate('Unknown')];
                            @endphp

                            <span class="i-badge capsuled {{ $status['class'] }}">{{ $status['text'] }}</span>
                        </td>


                        <td data-label="{{translate('Note')}}">
                            <div class="table-action">

                                @if(check_permission('update_leave'))

                                {{-- <button data-bs-toggle="tooltip" data-bs-placement="top" leave="{{$leave}}"
                                    data-bs-title="{{translate('Approve/Decline')}}" class="approve icon-btn info">
                                    <i class="las la-check-circle"></i>
                                </button> --}}

                                <a href="{{route('admin.leave.edit' , $leave->id)}}">
                                    <button data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Edit')}}" class="edit icon-btn info">
                                    <i class="las la-edit"></i>
                                    </button>
                                </a>

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
            {{ $leaves->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')

<div class="modal fade modal-md" id="editLeaveModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
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
            <form action="{{route('admin.leave.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="leave_id">
                    <input type="hidden" name="user_id">
                    <div class="row">

                        <div class="col-12">
                            <div class="form-inner">
                                <label for="leave_type_id">{{translate('Leave Type')}} <small
                                        class="text-danger">*</small></label>

                                <select name="leave_type_id" id="leave_type_id" class="select2" required>
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

{{-- Approve modal --}}
<div class="modal fade modal-md" id="approveModal" tabindex="-1" aria-labelledby="approveModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Approve /Decline')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>

            <form action="{{route('admin.leave.status')}}" method="POST">
                @csrf

                <div class="modal-body">

                    <input type="hidden" name="leave_id">

                    <div class="col-12">
                        <div class="form-inner">
                            <label for="leave_status">{{translate('Status')}}</label>
                            <select name="leave_status" id="leave_status" class="select2">
                                <option value="">{{translate('Select Status')}}</option>
                                @foreach(\App\Enums\LeaveStatus::toArray() as $key=>$leaveStatus);

                                <option value="{{$leaveStatus}}">{{$key}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-inner">
                        <label for="view_reason">{{translate('Reason :')}}</label>
                        <textarea name="reason" id="view_reason" cols="30" rows="10"> </textarea>
                    </div>

                    <div class="form-inner">
                        <label for="note">{{translate('Note')}}</label>
                        <textarea name="note" id="note" cols="30" rows="10"> </textarea>
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

    $('.edit').on('click', function () {

        var leave = JSON.parse($(this).attr("leave"));
        var modal = $('#editLeaveModal')

        modal.find('#leave_type_id').select2({
            placeholder: "{{translate('Select Leave Type')}}",
            dropdownParent: modal,
        });

        modal.find('#leave_duration_type').select2({
            placeholder: "{{translate('Select Leave Duration Status')}}",
            dropdownParent: modal,
        });

        modal.find('input[name="leave_id"]').val(leave.id);
        modal.find('input[name="user_id"]').val(leave.user_id);
        modal.find('select[name="leave_type_id"]').val(leave.leave_type_id).trigger('change');
        modal.find('select[name="leave_duration_type"]').val(leave.leave_duration_type).trigger('change');
        modal.find('input[name="date"]').val(leave.date);
        modal.find('input[name="start_date"]').val(leave.start_date);
        modal.find('input[name="end_date"]').val(leave.end_date);
        modal.find('textarea[name="reason"]').val(leave.reason);
        modal.modal('show');
    });

    $('#leave_duration_type').on('change', function () {
        if ($(this).val() === 'Range') {

            $('#single_date_picker').addClass('d-none');
            $('#range_date_picker').removeClass('d-none');
        } else {

            $('#single_date_picker').removeClass('d-none');
            $('#range_date_picker').addClass('d-none');
        }
    });


    $('.approve').on('click', function () {

        var leave = JSON.parse($(this).attr("leave"));
        var modal = $('#approveModal')

        modal.find('#leave_status').select2({
            placeholder: "{{translate('Select Status')}}",
            dropdownParent: modal,
        });
        modal.find('input[name="leave_id"]').val(leave.id);
        modal.find('select[name="leave_status"]').val(leave.status).trigger('change');
        modal.find('textarea[name="reason"]').val(leave.reason);
        modal.find('textarea[name="note"]').val(leave.note);
        modal.modal('show');
    });

</script>
@endpush
