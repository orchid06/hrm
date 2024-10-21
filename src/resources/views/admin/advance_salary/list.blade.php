@extends('admin.layouts.master')
@section('content')
@php
     $currency       = session()->get('currency');
@endphp
<div class="i-card-md">
    <div class="card--header">
        <div class="action">
            <button type="button" data-bs-toggle="modal" data-bs-target="#createAdvanceSalary"
                class="add i-btn btn--sm success">
                <i class="las la-plus me-1"></i> {{translate('Create')}}
            </button>
        </div>
        <div class="search-action-area">
            <div class="row g-3">

                <div class="col-md-12 d-flex justify-content-md-end justify-content-start">

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
                                    <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' :''
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
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' :
                                        ''}}>
                                        {{ $year }}
                                    </option>
                                    @endforeach
                                </select>
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
    </div>
    <div class="card-body">
        <div class="table-container position-relative">
            @include('admin.partials.loader')
            <table>
                <thead>
                    <tr>
                        <th scope="col">
                            {{translate('Name')}}
                        </th>

                        <th scope="col"  >
                            {{translate('For Month')}}
                        </th>
                        <th scope="col">
                            {{translate('Amount')}}
                        </th>
                        <th scope="col">
                            {{translate('Issued on')}}
                        </th>
                        <th scope="col">
                            {{translate('Option')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advanceSalaries  as $advanceSalary)

                        <tr>
                            <td data-label="{{translate('Name')}}">
                                <div class="user-meta-info d-flex align-items-center gap-2">
                                    <img class="rounded-circle avatar-sm"  src='{{imageURL(@$advanceSalary->user->file,"profile,user",true) }}' alt="{{@$advanceSalary->user->file->name}}">
                                    <p>	{{ $advanceSalary->user->name ?? translate("N/A")}}</p>

                                </div>
                            </td>
                            <td data-label='{{translate("For Month")}}'>
                                <div class="d-block">
                                    <span class="i-badge info">{{\Carbon\Carbon::parse($advanceSalary->for_month)->format('F') }}</span>
                                </div>
                            </td>
                            <td data-label="{{translate('Amount')}}">
                                <span class="i-badge capsuled warning" >{{num_format(@json_decode($advanceSalary->amount) , $currency)}}</span>
                            </td>

                            <td data-label="{{translate('Issued on')}}">
                                {{\Carbon\Carbon::parse($advanceSalary->created_at)->format('F j, Y \a\t h:i A') }}
                            </td>

                            <td data-label="{{translate('Options')}}">

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
                {{ $advanceSalaries->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade modal-md" id="createAdvanceSalary" tabindex="-1" aria-labelledby="createAdvanceSalary" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Pay Advance Salary')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.salary.advance.store')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">

                    <div class="form-inner">
                        <label for="userId">{{translate('Employee')}} <small class="text-danger">*</small></label>
                        <select name="userId" class="select2" id="userId" placeholder="{{translate('Select a Employee')}}">
                            <option value="">{{translate('Select an Employe')}}</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" >
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-inner">
                        <label for="for_month">{{translate('For Month')}} <small class="text-danger">*</small></label>
                        <select name="for_month" class="select2" id="for_month"
                            placeholder="{{translate('Select a month')}}">
                            <option value="">{{translate('Select a month')}}</option>
                            @foreach(range(\Carbon\Carbon::now()->month, 12) as $month)
                            <option value="{{ $month }}" >
                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-inner">
                        <label for="amount">{{translate('Amount')}}<small class="text-danger">*</small></label>
                        <input type="number" name="amount" id="amount" required>
                    </div>

                    <div class="form-inner">
                        <label for="note">{{ translate('Note') }}</label>
                        <textarea name="note" id="note" required></textarea>
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
    "use strict"
    $('.select2').each(function () {
        $(this).select2({
            placeholder: $(this).attr('placeholder')
        });
    });

    $('#createAdvanceSalary').on('shown.bs.modal', function () {
            $(".select2").select2({
                placeholder: $(this).attr('placeholder'),
                dropdownParent: $("#createAdvanceSalary"),
            })
        });
</script>
@endpush
