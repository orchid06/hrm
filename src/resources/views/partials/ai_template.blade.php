<h4 class="fs-18 mb-4">
    {{translate('Templates')}}
</h4>
<div class="template-wrapper scroll-design">

    @forelse ($templates as $template)

            <a href="javascript:void(0)" data-id="{{$template->id}}" class="template-item ai-template-item">
                <div class="icon">
                    <i class="{{$template->icon}}"></i>
                </div>
                <h6>
                    {{$template->name}}
                </h6>
            </a>
        
    @empty
        <div class="text-center">
             {{ 
                translate('No template found!')
             }}
        </div>
    @endforelse

</div>