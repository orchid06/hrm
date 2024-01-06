@php
   $templateContent  = get_content("content_template")->first();
   $templateElements = get_content("element_template");
   $templates        = App\Models\AiTemplate::with(['category'])
                          ->active()
                          ->default()
                          ->take(6)
                          ->inRandomOrder()
                          ->get();

@endphp

<section class="template bg--white pt-110 pb-110">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 mx-auto">
          <div class="section-title text-center">
            <span>{{$templateContent->value->sub_title}}</span>
            <h3 class="title-anim">
                {{$templateContent->value->title}}
            </h3>
            <p>
              {{$templateContent->value->description}}
            </p>
          </div>
        </div>
      </div>

      <div class="row g-4 justify-content-center">

        @forelse ($templates  as $template)

          <div class="col-lg-4 col-md-6">
              <div class="template-card fade-item">
                <span class="template-icon">
                  <i class="{{$template->icon}}"></i>
                </span>

                <div class="template-card-content">

                  <h4>
                        {{$template->name}}
                  </h4>
                  <p>
                    {{$template->description}}
                  </p>

                </div>
              </div>
          </div>

        @empty
              @include("frontend.partials.not_found")
        @endforelse


      </div>
    </div>
</section>
