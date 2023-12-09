@extends('layouts.master')
@section('content')

@php
  
   $contactSection   = get_content("content_contact_us")->first();  

   $file   = $contactSection->file->where("type",'image')->first();

@endphp

<section class="inner-banner">
      <div class="container">
        <div class="row align-items-center gy-4">
          <div class="col-lg-12">
            <div class="inner-banner-content">
              <h2>{{@$page->title}}</h2>

            </div>
          </div>

       
        </div>
      </div>

      <div class="primary-shade"></div>
      <div class="banner-texture"></div>
</section>


<section class="contact pb-110">
  <div class="container">
    <div class="row g-5">

          @php echo $page->description @endphp
    
    </div>
  </div>



</section>




@endsection

