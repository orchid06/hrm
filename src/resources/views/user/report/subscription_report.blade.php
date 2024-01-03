@extends('layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div>
      <div
        class="w-100 d-flex align-items-end justify-content-between gap-lg-5 gap-3 flex-md-nowrap flex-wrap mb-4">
        <h4>
            {{translate(Arr::get($meta_data,'title'))}}
        </h4>

        <div>
          <button
            class="icon-btn icon-btn-lg info circle"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#tableFilter"
            aria-expanded="false"
            aria-controls="tableFilter">
            <i class="bi bi-funnel"></i>
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

                    <div class="form-inner">
                        <select name="package" id="package" class="package">
                            <option value="">
                                {{translate('Select Package')}}
                            </option>
                            @foreach($packages as $package)
                            <option  {{$package->slug ==  request()->input('package') ? 'selected' :""}}
                                value="{{$package->slug}}"> {{$package->title}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-inner">
                        <input type="text"  name="search" value="{{request()->input('search')}}" placeholder='{{translate("Search by transaction id")}}'>
                    </div>

                    <div class="d-flex gap-2">
                            <button type="submit" class="i-btn primary btn--lg rounded">
                                <i class="bi bi-search"></i>
                            </button>

                            <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--lg danger rounded">
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
                                                        {{translate("Trx Code")}}
                                                    </h6>
                                                    <p> {{$report->trx_code}}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-center text-start">
                                            <div class="table-accordion-header">
                                                <h6>
                                                    {{translate("Expired In")}}
                                                </h6>

                                                <p>
                                                    @if($report->expired_at)
                                                    {{ get_date_time($report->expired_at) }}
                                                    @else
                                                        {{translate("N/A")}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-end text-end">
                                            <div class="table-accordion-header">
                                                <h6>
                                                    {{translate("Package")}}
                                                </h6>

                                                <p>
                                                    {{@$report->package->title}}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-start">
                                            <div class="table-accordion-header">
                                                <h6>
                                                    {{translate("Status")}}
                                                </h6>
                                                @php echo subscription_status($report->status) @endphp
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-sm-4 col-6 text-sm-center text-end">
                                            <div class="table-accordion-header">
                                                <h6>
                                                    {{translate("Payment Amount")}}
                                                </h6>
                                                <p>
                                                    {{@num_format(
                                                        number : $report->payment_amount??0,
                                                        calC   : true
                                                    )}}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-sm-4 col-6 text-sm-end text-start">
                                            <div class="table-accordion-header">
                                                <h6>
                                                    {{translate("Date")}}
                                                </h6>

                                                <p>
                                                    @if($report->created_at)
                                                        {{ get_date_time($report->created_at) }}
                                                    @else
                                                        {{translate("N/A")}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="collapse{{$report->id}}" class="accordion-collapse collapse" data-bs-parent="#wordReports">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">

                                        @php
                                            $informations = [

                                                "Ai Word Balnace"          => $report->word_balance,
                                                "Remaining Word Balance"   => $report->remaining_word_balance,
                                                "Carried Word Balnace"     => $report->carried_word_balance,
                                                "Total Social Profile"     => $report->total_profile,
                                                "Carried Profile Balnace"  => $report->carried_profile,
                                                "Social Post Balnace"      => $report->post_balance,
                                                "Remaining Post Balance"   => $report->remaining_post_balance,
                                                "Carried Post Balnace"     => $report->carried_post_balance,
                                            ];
                                        @endphp


                                        @foreach ($informations  as  $key => $val)

                                            <li class="list-group-item">
                                                <h6 class="title">
                                                    {{k2t($key)}}
                                                </h6>
                                                <p class="value">
                                                    {{$val == App\Enums\PlanDuration::UNLIMITED->value ? App\Enums\PlanDuration::UNLIMITED->name : $val }}
                                                </p>
                                            </li>

                                        @endforeach


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



@endsection


@push('script-include')
   <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";

        $(".package").select2({

        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });



	})(jQuery);
</script>
@endpush





