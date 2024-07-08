@extends('layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
@php
   $user = auth_user('web');
@endphp


<div class="row">
    <div class="col-xl-12 col-lg-12 mx-auto">
        <div class="w-100 d-flex align-items-center justify-content-between flex-md-nowrap flex-wrap gap-lg-5 gap-3 mb-4">
            <div>
                <h4>
                    {{translate(Arr::get($meta_data,'title'))}}
                </h4>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    {{translate("Total Affiliate Users")}} <span class="ms-2 i-badge capsuled danger"> {{ $user->affilateUser->count()}} </span>
                </div>

                <button
                    class="icon-btn icon-btn-lg solid-info circle"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#tableFilter"
                    aria-expanded="false"
                    aria-controls="tableFilter">
                    <i class="bi bi-sliders"></i>
                </button>
            </div>
        </div>

        <div class="collapse filterTwo mb-3" id="tableFilter">
            <div class="i-card-md">
                <div class="card-body">
                    <div class="search-action-area p-0">
                        <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}">

                            <div class="form-inner">
                                <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder='{{translate("Filter by date")}}'>
                            </div>

                            @if($user->affilateUser)
                                <div class="form-inner">
                                    <select name="referral" id="referral" class="referral">
                                        <option value="">
                                            {{translate('Select User')}}
                                        </option>

                                        @foreach($user->affilateUser as $affilateUser)
                                            <option  {{Arr::get($affilateUser,"username",null) ==   request()->input('user') ? 'selected' :""}} value="{{Arr::get($affilateUser,"username",null)}}"> {{Arr::get($affilateUser,"name",null)}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="form-inner">
                                <input type="text"  name="search" value="{{request()->input('search')}}"  placeholder='{{translate("Search by Transaction ID")}}'>
                            </div>


                            <div class="d-flex gap-2">
                                <button type="submit" class="i-btn primary btn--lg capsuled">
                                    <i class="bi bi-search"></i>
                                </button>

                                <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--lg danger capsuled">
                                    <i class="bi bi-arrow-repeat"></i>
                                </a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="i-card-md">
            <div class="card-body p-0">
                <div class="table-accordion">
                    @if($reports->count() > 0)
                        <div class="accordion" id="wordReports">
                            @forelse($reports as $report)
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$report->id}}"
                                            aria-expanded="false" aria-controls="collapse{{$report->id}}">
                                            <div class="row align-items-center w-100 gy-4 gx-sm-3 gx-0">
                                                <div class="col-lg-2 col-sm-4 col-12">
                                                    <div class="table-accordion-header transfer-by">
                                                        <span class="icon-btn icon-btn-sm info circle">
                                                            <i class="bi bi-arrow-up-left"></i>
                                                        </span>
                                                        <div>
                                                            <h6>
                                                                {{translate("TRX Code")}}
                                                            </h6>
                                                            <p> {{$report->trx_code}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-center text-start">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Date")}}
                                                        </h6>
                                                        <p> {{ get_date_time($report->created_at) }}</p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-end text-end">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Reffered User")}}
                                                        </h6>
                                                        <p>
                                                            @if($report->referral)
                                                                {{$report->referral->name}}
                                                            @else
                                                                {{translate('N/A')}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-start">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Subscription Package")}}
                                                        </h6>
                                                        <p>
                                                            {{$report->subscription? @$report->subscription->package->title  : 'N/A'}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-sm-center text-end">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Commission Rate")}}
                                                        </h6>
                                                        <p>{{$report->commission_rate}}%</p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-sm-end text-start">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Amount")}}
                                                        </h6>
                                                        <p>
                                                            {{@num_format(
                                                                number : $report->commission_amount??0,
                                                                calC   : true
                                                            )}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="collapse{{$report->id}}" class="accordion-collapse collapse" data-bs-parent="#wordReports">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">

                                                <li class="list-group-item">
                                                    <span class="i-badge-solid warning fs-6 ">
                                                        {{ translate('Note') }}
                                                    </span>

                                                    <p>{{($report->note)}}</p>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                    </div>
                    @else
                        @include('admin.partials.not_found',['custom_message' => "No Reports found!!"])
                    @endif
                </div>
            </div>
        </div>

        <div class="Paginations">
            {{ $reports->links() }}
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
	(function($){

        "use strict";

        $(".type").select2({

        });

   

	})(jQuery);
</script>
@endpush





