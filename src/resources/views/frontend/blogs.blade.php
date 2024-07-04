@extends('layouts.master')
@section('content')

  @php
      $blogContent  = get_content("content_blog")->first();
  @endphp

@include("frontend.partials.breadcrumb")

<section class="blog-section">
  <div class="container">
    <div class="row justify-content-start">
      <div class="col-lg-5">
        <div class="section-title-one text-start mb-60">
          <div class="subtitle">{{@$blogContent->value->sub_title}}</div>
          <h2>
              @php echo @$blogContent->value->title @endphp
         </h2>
          <p>{{@$blogContent->value->description}}</p>
        </div>
      </div>
    </div>
    <div class="row g-xl-5 g-4">
        @forelse ($blogs as $blog)
            @include("frontend.partials.blog_component")
        @empty
             <div class="col-12">
                  @include("frontend.partials.not_found")
             </div>
        @endforelse
    </div>

    <div class="pagination">
          {{$blogs->links()}}
    </div>
  </div>
</section>

  @include('frontend.partials.page_section')

@endsection

