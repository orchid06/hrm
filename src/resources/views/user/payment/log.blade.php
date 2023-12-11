@extends('layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />

@endpush

@section('content')

   <section class="bg-light-1">
    <div class="dashboard-body">
        <div class="sidebar-menu-container">
          <div class="sidebar-menu-content" data-simplebar>
              @include('user.partials.sidebar')
          </div>
        </div>

        <div class="dashboard-container">
          <div class="dashboard-content">
            <div class="box">
                <div class="box-header">
                    <h4>
                      {{translate("Payment Logs")}}
                    </h4>
                </div>

                <div class="t-filter">    
                    <form class="t-filter-form" action="{{route(Route::currentRouteName())}}">
                        <div class="row g-2">
                          <div class="col-xl-7 col-lg-7 col-md-8">                      
                              <div class="row g-2">
                                  <div class="col-xl-6 col-md-7">
                                      <div class="form-inner mb-0">
                                          <input type="text" value="{{request()->input('trx_id')}}" name="trx_id" placeholder="{{translate("Enter Transaction Id")}}">
                                      </div>
                                  </div>

                                  <div class="col-xl-4 col-md-5">
                                      <div class="form-inner mb-0">
                                          <input type="date" id="date_picker" name="date" value="{{request()->input('date')}}" placeholder="{{translate("Enter Date")}}">
                                      </div>
                                  </div>
                              </div>                               
                          </div>

                            <div class="col-xl-5 col-lg-5 col-md-4">
                                <div class="t-filter-btn-group justify-content-end">
                                    <button type="submit" class="filter-btn bg-soft-info">
                                        <i class="fa-regular fa-sliders"></i>
                                        {{translate("Filter")}}
                                    </button>
                                    <a href="{{route('user.payment.log')}}" class="filter-btn bg-soft-danger">
                                      <i class="fa-solid fa-rotate"></i> {{translate("Reset")}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                  <table>
                    <thead>
                      <tr>
                        <th scope="col">
                            {{translate("Transaction Id")}}
                        </th>
                        <th scope="col">
                            {{translate("Payment Method")}}
                        </th>
                        <th scope="col">
                            {{translate("Amount")}}
                        </th>

                        <th scope="col">
                          {{translate("Date")}}
                        </th>
            
                        <th scope="col">
                            {{translate("Status")}}
                        </th>

                        <th scope="col">
                            {{translate("Options")}}
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      @forelse($payment_logs as $log)
                        <tr>
                          <td data-label="{{translate("Transaction Id")}}">{{$log->trx_code}}</td>

                          <td data-label="Payment type">
                              {{$log->method->name}}
                            </td>

                          <td data-label="Amount">
                              {{$log->method->currency_symbol}} {{round($log->final_amount)}} 
                          </td>

                          <td data-label="{{translate("Date")}}">
                              {{diff_for_humans($log->created_at)}}
                          </td>

                          <td data-label="{{translate("Status")}}">
                             @php echo log_status($log->status) @endphp
                          </td>

                          <td data-label="{{translate("Options")}}">
                            <a href="{{route('user.payment.log.show',$log->id)}}" type="button" class="link-edit-btn icon-btn rounded-circle bg-soft-info">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                          </td>

                        </tr>
                        @empty 
                        <tr class="border-bottom-0">
                            <td class="border-bottom-0" colspan="100">
                                @include('frontend.partials.not_found')
                            </td>
                        </tr>
                      @endforelse
                      
                    </tbody>
                  </table>
                </div>

                <div class="Paginations justify-content-end">
                  <ul class="Pagination">
                      {{ $payment_logs->links() }}
                  </ul>
                </div>
            </div>
        </div>
    </div>
  </section>

@endsection


@push('script-include')
   <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){
       	"use strict";

        flatpickr("#date_picker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });

    

	})(jQuery);
</script>
@endpush
