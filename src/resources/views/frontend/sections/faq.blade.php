@php
   $content             = get_content("content_faq")->first();
   $elemets             = get_content("element_faq");
@endphp

<section class="faqs bg--light sectionWithBg pt-110 pb-110">
    <div class="container">
      <div class="row">
        <div class="col-xl-7 col-lg-8 mx-auto">
          <div class="section-title text-center">
            <span>{{@$content->value->sub_title}}</span>
            <h3 class="title-anim">
                {{@$content->value->title}}
            </h3>
            <p>
              {{@$content->value->description}}
            </p>
          </div>
        </div>
      </div>

      <div class="faq-wrap">
        <div class="accordion" id="faqAccordion">

          @forelse($elemets  as $element)

            <div class="accordion-item">
              <h2 class="accordion-header" id="headng-{{$loop->index}}">
                <button
                  class='accordion-button  {{$loop->index != 0  ? "collapsed" :""}}'
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapse-{{$loop->index}}"
                  aria-expanded="false"
                  aria-controls="collapse-{{$loop->index}}">
                  <i class="{{ $element->value->icon}}"></i>
                  {{$element->value->question}}
                </button>
              </h2>
              <div id="collapse-{{$loop->index}}" class='accordion-collapse  collapse {{$loop->index == 0  ? "show" :""}}  ' aria-labelledby="headng-{{$loop->index}}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  <p>
                    {{$element->value->answer}}
                  </p>
                </div>
              </div>
            </div>
          @empty
             @include("frontend.partials.not_found")
          @endforelse


        </div>
      </div>
    </div>
</section>
