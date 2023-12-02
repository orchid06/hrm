@extends('admin.layouts.master')

@section('content')

    <form action="{{route("dos.security.verify")}}" class="add-listing-form" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row g-4">

            <div class="col-xl-12">
                <div class="i-card-md">
                    <div class="card--header">
                        <h4 class="card-title">
                            {{translate('Basic Information')}}
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <a id='genarate-captcha' class="align-middle justify-content-center pointer ">
                                        <img class="captcha-default d-inline me-2  " src="{{ route('captcha.genarate',1) }}" id="default-captcha">
                                        <i class="fa-sharp fa-light fa-rotate fs-22"></i>
                                    </a>
                                </div>

                                <div class="form-inner">

                                    <input type="text" name="captcha" id="captcha"  placeholder="{{translate("Enter captcha code")}}">  

                                </div>

                            </div>
                     
                            <div class="col-lg-12 mt-4">
                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                    {{translate("Submit")}}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
   </form>


@endsection


@push('script-push')
<script>
	(function($){

        $(document).on('click','#genarate-captcha',function(e){
            var url = "{{ route('captcha.genarate',[":randId"]) }}"
            url = (url.replace(':randId',Math.random()))
            document.getElementById('default-captcha').src = url;
            e.preventDefault()
        })



    })(jQuery);
</script>
@endpush
