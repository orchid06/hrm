@extends('layouts.master')
@section('content')
     @php
        $breadcrumb = frontend_section()->where("slug",'breadcrumb_section')->first();
     @endphp
     @includeWhen(@site_settings('breadcrumbs') == App\Enums\StatusEnum::true->status(),'frontend.partials.breadcrumb',['breadcrumb' => $breadcrumb])
      <section class="bg-light-1 pt-110 pb-110">
        <div class="container">
          <div class="row gy-5 position-relative">
            <div class="col-lg-9 order-lg-1 order-2">
              <div class="section-title text-start mb-10">
                <h2 class="title-header">
                    {{@get_translation($page->title)}}
                </h2>
              </div>
              <div class="about-content">
                  @php echo @get_translation($page->description) @endphp
              </div>
            </div>

            @if(site_settings("google_ads") != App\Enums\StatusEnum::true->status())
              <div class="col-lg-3 order-lg-2 order-1">
                  @if(add_shortcode("page_details"))
                    <div class="box-sm sticky-side-div">
                        @php echo add_shortcode("page_details") @endphp
                    </div>
                  @endif
              </div>
            @endif
          </div>
        </div>
      </section>
@endsection
