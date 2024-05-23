<div class="i-card-md">
    @if(!@$header)
        <div class="card--header">
            <h4 class="card-title">
                    {{translate('Summery')}}
            </h4>
        </div>
    @endif
    <div class="card-body">


        @if(@$header)
            <div class="card card--hover linear-card bg--linear-primary text-center mb-3">
                <div class="card-body p-3">
                    <h6 class="text-white opacity-75 fw-normal fs-13">
                         {{Arr::get($header_info,'title')}}
                    </h6>
                    <h4 class="fw-bold mt-1 mb-3 text-white fs-18">{{Arr::get($header_info,'total')}} </h4>
                    <p class="text-white opacity-75">{{Arr::get($header_info,'note')}}</p>
                </div>
            </div>
        @endif

        <ul class="subcription-list">


            @foreach ($summaries as $key => $value )
                   <li><span> {{ k2t($key)}}  </span><span> {{$value}} </span></li>     
            @endforeach
  
        </ul>
    </div>
</div>