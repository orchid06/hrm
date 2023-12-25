@extends('layouts.master')
@section('content')

   {{-- <section class="bg-light-1">
        <div class="dashboard-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <div class="box secbg">
                            <div>
                                <div class="mb-50 text-center">
                                    <h3 class="title">{{translate('Please follow the instruction below')}}</h3>
                                    <p class="mt-2 ">{{translate('You have requested for a subscription')}}
                                    </p>
                                </div>

                                <div>
                                    {{translate('Plan Amount')}} <b class="text--base"> {{site_settings('currency_symbol')}} {{round_amount($log->amount)}}
                                        </b> , {{translate('Please Pay')}}

                                    <b class="text--base">{{$log->method->currency_symbol}} {{round_amount($log->final_amount)}}</b>  {{translate('(charge included) for successful payment')}}
                                </div>
                                <div class="payment-note">
                                    <p>
                                        <?php echo @$log->method->payment_notes; ?>
                                    </p>
                                </div>

                                <form action="{{route('user.payment.manual')}}" method="post" enctype="multipart/form-data"
                                        class="form-row preview-form mt-20">
                                    @csrf
                                    @if(optional($log->method)->parameters)
                                        @php
                                            $params = json_decode(($log->method)->parameters);
                                        @endphp
                                        <div class="row">
                                            @foreach($params as $k => $v)
                                                @if($v->type == "text")
                                                    <div class="col-md-12">
                                                        <div class="form-inner">
                                                            <label>{{translate($v->field_label)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif </label>
                                                            <input class=" " placeholder="{{$k}}" type="text" name="{{$k}}"   @if($v->validation == "required") required @endif>
                                                            @if ($errors->has($k))
                                                                <span class="text-danger">{{ translate($errors->first($k)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @elseif($v->type == "textarea")
                                                        <div class="col-md-12 mt-2">
                                                            <div class="form-inner">
                                                                <label>{{translate($v->field_label)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif </label>
                                                                <div class="form-group input-box">
                                                                    <textarea class=" " placeholder="{{$k}}" name="{{$k}}"  rows="3" @if($v->validation == "required") required @endif></textarea>
                                                                    @if ($errors->has($k))
                                                                        <span class="text-danger">{{ translate($errors->first($k)) }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @elseif($v->type == "file")
                                                        <div class="col-md-12">
                                                            <div class="form-inner">
                                                                <label>{{translate($v->field_label)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif </label>
                                                                <div class="img-input-div">
                                                                    <input type="file" name="{{$k}}" accept="image/*"
                                                                        @if($v->validation == "required") required @endif>
                                                                </div>
                                                            </div>
                                                        </div>

                                                @endif

                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="col-12 ">
                                        <button type="submit" class="ig-btn btn--primary btn--md">
                                            {{translate("Pay Now")}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </section> --}}

@endsection



