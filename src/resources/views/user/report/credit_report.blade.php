@extends('layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')


<div class="row">
    <div class="col-xl-12 col-lg-12 mx-auto">
      <div
        class="w-100 d-flex align-items-end justify-content-between gap-lg-5 gap-3 flex-md-nowrap flex-wrap mb-4">
        <div>
            <h4>
                {{translate(Arr::get($meta_data,'title'))}}
            </h4>
        </div>

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
                        <select name="trx_type" id="type" class="type">
                            <option value="">
                                {{translate('Select Trx type')}}
                            </option>
                            <option {{ App\Models\Transaction::$PLUS == request()->input('trx_type') ? 'selected' :""  }} value="{{App\Models\Transaction::$PLUS}}">{{translate("Plus")}}</option>
                            <option {{ App\Models\Transaction::$MINUS == request()->input('trx_type') ? 'selected' :""  }} value="{{App\Models\Transaction::$MINUS}}">{{translate("Minus")}}</option>
             
                        </select>
                    </div>

                    <div class="form-inner">
                        <input type="text"  name="search" value="{{request()->input('search')}}"  placeholder='{{translate("Search by transaction id or remarks")}}'>
                    </div>

                 
                    <div class="d-flex gap-2">
                            <button type="submit" class="i-btn primary btn--lg">
                                <i class="bi bi-search"></i>
                            </button>

                            <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger">
                                <i class="bi bi-arrow-repeat"></i>
                            </a>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

        <div class="table-accordion">

                @if($reports->count() > 0)
                    <div class="accordion" id="wordReports">

                        @forelse($reports as $report)

                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$report->id}}"
                                        aria-expanded="false" aria-controls="collapse{{$report->id}}">
                                        <div class="row align-items-center w-100 gy-2">

                                            <div class="col">
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


                                            <div class="col text-sm-center">
                                                <div class="table-accordion-header">
                                                <h6>
                                                    {{translate("Date")}}
                                                </h6>
                                                {{ get_date_time($report->created_at) }}
                                                </div>
                                            </div>

                                            <div class="col text-center">
                                                <div class="table-accordion-header">
                                                    <h6>
                                                        {{translate("Credit")}}
                                                    </h6>

                                                    <span class='text--{{$report->type == App\Models\Transaction::$PLUS ? "success" :"danger" }}'>
                                                        <i class='bi bi-{{$report->type == App\Models\Transaction::$PLUS ? "plus" :"dash" }}'></i>
                                                        @if(App\Enums\PlanDuration::value('UNLIMITED') == $report->balance)
                                                          {{translate('Unlimited')}}
                                                        @else
                                                          {{$report->balance}}
                                                        @endif
                                                    </span>
                                                
                                                </div>
                                            </div>

                                            <div class="col text-sm-center">
                                                <div class="table-accordion-header">
                                                    <h6>
                                                        {{translate("Post Credit")}}
                                                    </h6>
                                                    @if(App\Enums\PlanDuration::value('UNLIMITED') == $report->post_balance)
                                                        {{translate('Unlimited')}}
                                                    @else
                                                        {{$report->post_balance}}
                                                    @endif
                                                
                                                </div>
                                            </div>

                                            <div class="col text-sm-center">
                                                <div class="table-accordion-header">
                                                    <h6>
                                                        {{translate("Remark")}}
                                                    </h6>
                                                    {{k2t($report->remark)}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapse{{$report->id}}" class="accordion-collapse collapse" data-bs-parent="#wordReports">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <h6 class="title">
                                                    {{translate("Report Information")}}
                                                </h6>
                                                <p class="value">
                                                    {{$report->details}}
                                                </p>
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

      
        <div class="Paginations">

            {{ $reports->links() }}
        
        </div>
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
        $(".type").select2({
           
        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });



	})(jQuery);
</script>
@endpush




