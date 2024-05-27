<ul class="custom-info-list list-group-flush">

    @foreach ($lists as  $list)

            <li><span>{{ Arr::get($list, 'title') }}:</span> 
                  @php 
                     $value = Arr::get($list,'value') ;
                  @endphp
                @if(Arr::has($list,'href'))
                        <a href='{{Arr::get($list,'href')}}'>
                        {{   $value }}
                    </a>
                @else
                     @if(Arr::has($list,'is_html'))
                          @php echo $value @endphp
                     @else
                         <span>
                            {{   $value }}
                         </span>
                     @endif
                @endif
            </li>
    @endforeach

</ul>