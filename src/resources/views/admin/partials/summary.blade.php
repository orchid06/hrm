<div class="i-card-md">
    <div class="card--header">
        <h4 class="card-title">
                {{translate('Summery')}}
        </h4>
    </div>
    <div class="card-body">

        <ul class="subcription-list">


            @foreach ($summaries as $key => $value )
                   <li><span> {{ k2t($key)}}  </span><span> {{$value}} </span></li>     
            @endforeach
  
        </ul>
    </div>
</div>