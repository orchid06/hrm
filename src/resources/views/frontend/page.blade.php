@extends('layouts.master')
@section('content')

@php
   $contactSection   = get_content("content_contact_us")->first();
   $file   = $contactSection->file->where("type",'image')->first();
@endphp

<section class="inner-banner">
    <div class="inner-banner-wrapper">
      <div class="inner-banner-img">
        <img src="https://i.ibb.co/NV4XHHy/banner-bg.png" alt="banner-bg">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-xl-7 col-lg-8 mx-auto">
            <div class="inner-banner-content text-center">
            <h2>{{@$page->title}}</h2>
            <p>
              {{@$contactSection->value->banner_description}}
            </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
      <div class="shape-two">
        <img src="https://i.ibb.co/XkfL6RX/shape-bread.png" alt="shape-bread">
      </div>
      <div class="shape-one">
        <img src="https://i.ibb.co/XkfL6RX/shape-bread.png" alt="shape-bread">
      </div>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Library</li>
      </ol>
    </nav>
</section>

<!-- <section class="pages-wrapper  pb-110">
  <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-content linear-bg">
                @php echo $page->description @endphp
            </div>
        </div>
    </div>
  </div>
</section> -->

<section class="about-section pb-110">
  <div class="container">
    <div class="row gy-5">
      <div class="col-xl-5 pe-lg-5">
        <div class="section-title-one text-start mb-60">
          <div class="subtitle">About us</div>
          <h2>Our Values</h2>
          <p>Discover the power of our secure an rewarding credit cards. Discover th power of our secure and rewarding credit cards. Discover the power of our secure an rewarding credit cards. Discover th power of our secure and rewarding credit cards. </p>
        </div>
        <div class="counter-wrapper">
          <div class="row">
            <div class="col-md-6">
              <div class="counter-single text-center">
                  <div class="counter-text d-flex flex-column">
                      <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                          <h3 class="odometer" data-odometer-final="258">01</h3><i class="bi bi-plus-lg"></i>
                      </div>
                      <p>300+Our Customers</p>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="counter-single text-center">
                  <div class="counter-text d-flex flex-column">
                      <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                          <h3 class="odometer" data-odometer-final="258">01</h3><i class="bi bi-plus-lg"></i>
                      </div>
                      <p>300+Our Customers</p>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-7">
          <div class="about-card-wrapper">
            <div class="center-icon">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m476.855 307.148-29.937-29.933-42.426 42.426 29.938 29.933c23.39 23.395 23.39 61.465 0 84.856-23.39 23.39-61.461 23.39-84.856 0L192.36 277.215l-42.425 42.426 157.214 157.214c46.86 46.86 122.848 46.86 169.707 0s46.86-122.847 0-169.707zm0 0"  opacity="1" data-original="#000000" class=""></path><path d="M162.426 434.43c-23.395 23.39-61.465 23.39-84.856 0-23.39-23.39-23.39-61.461 0-84.856L234.785 192.36l-42.426-42.425L35.145 307.148c-46.86 46.86-46.86 122.848 0 169.707s122.847 46.86 169.707 0l29.933-29.937-42.426-42.426zM349.574 77.57c23.395-23.39 61.465-23.39 84.856 0 23.39 23.39 23.39 61.461 0 84.856L277.215 319.64l42.426 42.425 157.214-157.214c46.86-46.86 46.86-122.848 0-169.707s-122.847-46.86-169.707 0l-29.933 29.937 42.426 42.426zm0 0"  opacity="1" data-original="#000000" class=""></path><path d="m65.082 234.785 42.426-42.426-29.938-29.933c-23.39-23.395-23.39-61.465 0-84.856 23.39-23.39 61.461-23.39 84.856 0l163.426 163.426 42.425-42.426L204.852 35.145c-46.86-46.86-122.848-46.86-169.707 0s-46.86 122.847 0 169.707zm0 0"  opacity="1" data-original="#000000" class=""></path></g></svg>
            </div>
            <div class="row g-md-5 g-4">
              <div class="col-md-6">
                <div class="about-card-item">
                  <div class="icon">
                    <i class="bi bi-heart"></i>
                  </div>
                  <div class="content">
                    <h4>Trustworthy</h4>
                    <p>Discover the power of our secure an rewarding credit cards. Discover th power of our secure and rewarding credit cards.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="about-card-item">
                  <div class="icon">
                    <i class="bi bi-heart"></i>
                  </div>
                  <div class="content">
                    <h4>Takeover</h4>
                    <p>Discover the power of our secure an rewarding credit cards. Discover th power of our secure and rewarding credit cards.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="about-card-item">
                  <div class="icon">
                    <i class="bi bi-heart"></i>
                  </div>
                  <div class="content">
                    <p>Discover the power of our secure an rewarding credit cards. Discover th power of our secure and rewarding credit cards.</p>
                    <h4>Ingenious</h4>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="about-card-item">
                  <div class="icon">
                    <i class="bi bi-heart"></i>
                  </div>
                  <div class="content">
                    <p>Discover the power of our secure an rewarding credit cards. Discover th power of our secure and rewarding credit cards.</p>
                    <h4>Respect</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>

<section class="team-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="section-title-one text-center mb-60">
          <div class="subtitle">Team</div>
          <h2>Meet our <span>team</span></h2>
          <p>Lorem ipsum dolor sit amet consectetur adipiscing elit dolor posuere vel venenatis.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
      <div class="swiper team-slider">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="https://i.ibb.co/bbnJJQW/team-1.jpg" alt="team-1">
          </div>
          <div class="swiper-slide">
            <img src="https://i.ibb.co/CHrt5t7/team-2.jpg" alt="team-2">
          </div>
          <div class="swiper-slide">
            <img src="https://i.ibb.co/wJbfLnw/team-3.png" alt="team-3">
          </div>
          <div class="swiper-slide">
            <img src="https://i.ibb.co/myW3fsH/team-4.jpg" alt="team-4">
          </div>
          <div class="swiper-slide">
            <img src="https://i.ibb.co/PM99LYL/team-5.jpg" alt="team-5">
          </div>
          <div class="swiper-slide">
            <img src="https://i.ibb.co/ThBNNTq/team-6.jpg" alt="team-6">
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
      </div>
    </div>
  </div>
</section>

@endsection

