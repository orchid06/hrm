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
                   {{translate("Payment Information")}}
                </h4>
            </div>
            
            <div class="row">
                 <div class="col-lg-{{$log->custom_data?"6":"12"}}" class="mx-auto">
                        <h3>
                            {{translate("Basic Information")}}
                        </h3>
                      <ul class="list-group list-group-flush border mt-4 payment-info">
                        <li class="list-group-item">{{translate("Transaction Id")}} : <span class="payment-info-value">{{$log->trx_code}}</span></li>
                        <li class="list-group-item">{{translate('Payment Method')}} : <span class="payment-info-value">{{$log->method->name}}</span></li>
                        <li class="list-group-item">{{translate('Amount')}} :  <span class="payment-info-value">{{site_settings("currency_symbol")}} {{round($log->amount)}}</span></li>
                        <li class="list-group-item">{{translate('Charage')}} :  <span class="payment-info-value">{{site_settings("currency_symbol")}} {{round($log->charge)}}</span></li>
                        <li class="list-group-item">{{translate('Rate')}} :  <span class="payment-info-value">{{site_settings("currency_symbol")}} {{round($log->rate)}}</span></li>
                        <li class="list-group-item">{{translate('Final Amount')}} :  <span class="payment-info-value">     {{$log->method->currency_symbol}} {{round($log->final_amount)}} </span></li>

                        <li class="list-group-item">{{translate('Date')}} :  <span class="payment-info-value">{{diff_for_humans($log->created_at)}}</span></li>       
                        <li class="list-group-item">{{translate('Status')}} :    @php echo log_status($log->status) @endphp
                        </li>

                          <li class="list-group-item">{{translate('Feedback')}} : <span class="payment-info-value">{{$log->feedback ? $log->feedback  : translate("N/A") }}</span></li>
                  
                      </ul>
                 </div>

                 @if($log->custom_data)              
                    <div class="col-lg-6">
                        <h3>
                            {{translate("Custom  Information")}}
                        </h3>
                        <ul class="list-group list-group-flush border mt-4">
                            @foreach($log->custom_data as $k => $v)
                              <li class="list-group-item">{{translate(ucfirst($k))}} : 
                                  @if($v->type == 'file')
                                      @php
                                          $file = $log->file()->where("type",$k)->first();
                                      @endphp
                                      {{-- <img src="{{imageUrl(config("settings")['file_path']['payment']['path']."/".@$file->name ,@$file->disk ) }}" alt="{{@$file->name}}"> --}}
                                  @else
                                    {{$v->field_name}}
                                  @endif
                             </li>
                            @endforeach
                    
                        </ul>
                    </div>
                 @endif
   
            </div>
        </div>
      </div>
    </div>
  </section>

@endsection



