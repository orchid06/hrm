@php
   $content             = get_content("content_faq")->first();
   $elements             = get_content("element_faq");
@endphp

<div class="faq-section pb-110">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-5">
              <div class="section-title-one text-center mb-60">
                  <div class="subtitle">{{@$content->value->sub_title}}</div>
                  <h2>  @php echo @$content->value->title @endphp </h2>
                  <p> {{@$content->value->description}}</p>
              </div>
          </div>
      </div>

      <div class="faq-wrap">
          <div class="row gy-4">
                @forelse($elements  as $element)
                <div class="col-lg-6">
                    <div class="accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button  {{$loop->index != 0  ? 'collapsed' : ''}}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{$loop->index}}" aria-expanded="true" aria-controls="collapse-{{$loop->index}}">
                                        {{$element->value->question}}
                                    </button>
                                </h2>
                                <div id="collapse-{{$loop->index}}" class="accordion-collapse collapse {{$loop->index == 0  ? "show" :""}} "
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                    {{$element->value->answer}}
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                @empty
                  <div class="col-12">
                        @include("frontend.partials.not_found")
                  </div>
              @endforelse
        
          </div>
      </div>
  </div>
</div>



