@extends('layouts.master')
@section('content')

@php
   $blogContent  = get_content("content_blog")->first();
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
              <h2>
                  {{@$blogContent->value->banner_title}}
              </h2>
              <p>
                  {{@$blogContent->value->banner_description}}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<!-- Blog section start -->

<section class="blog-section pt-110">
  <div class="container">
    <div class="row justify-content-start">
      <div class="col-lg-5">
        <div class="section-title-one text-start mb-60">
          <div class="subtitle">Blog</div>
          <h2>News & <span>Blogs</span></h2>
          <p>Lorem ipsum dolor sit amet consectetur adipiscing elit dolor posuere vel venenatis eu sit massa volutpat.</p>
        </div>
      </div>
    </div>
    <div class="row g-xl-5 g-4">
      <div class="col-12">
        <div class="blog-style-one">
            <div class="row align-items-center g-3">
              <div class="col-md-7 pe-lg-4">
                <div class="image">
                  <img src="https://i.ibb.co/Vqn5C2x/Rectangle-38.jpg" alt="Rectangle-38">
                </div>
              </div>
              <div class="col-md-5">
                <div class="content">
                  <span>Social Media</span>
                  <h3><a href="blog-details.html">We Launch Pulsar Template this Week!</a></h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipiscing elit dolor posuere vel venenatis eu sit massa volutpat.</p>
                  <a href="#" class="i-btn btn--lg btn--primary capsuled">More info<span><i class="bi bi-arrow-up-right"></i></span></a>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="blog-style-two">
          <div class="date">10 January, 2024</div>
          <div class="content">
            <span>Social Media</span>
            <h4><a href="blog-details.html">We Launch Pulsar Template this Week!</a></h4>
          </div>
          <a href="#" class="i-btn btn--lg btn--white capsuled">More info<span><i class="bi bi-arrow-up-right"></i></span></a>
          <div class="blog-btn">
          </div>
          <div class="image">
            <img src="https://i.ibb.co/pb0cvp1/blog1.jpg" alt="blog1">
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="blog-style-two">
          <div class="date">10 January, 2024</div>
          <div class="content">
            <span>Social Media</span>
            <h4><a href="blog-details.html">We Launch Pulsar Template this Week!</a></h4>
          </div>
          <a href="#" class="i-btn btn--lg btn--white capsuled">More info<span><i class="bi bi-arrow-up-right"></i></span></a>
          <div class="blog-btn">
          </div>
          <div class="image">
            <img src="https://i.ibb.co/fDGrvZC/blog2.jpg" alt="blog2">
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="blog-style-two">
          <div class="date">10 January, 2024</div>
          <div class="content">
            <span>Social Media</span>
            <h4><a href="blog-details.html">We Launch Pulsar Template this Week!</a></h4>
          </div>
          <a href="#" class="i-btn btn--lg btn--white capsuled">More info<span><i class="bi bi-arrow-up-right"></i></span></a>
          <div class="blog-btn">
          </div>
          <div class="image">
            <img src="https://i.ibb.co/nr0BqCr/blog3.jpg" alt="blog3">
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="blog-style-two">
          <div class="date">10 January, 2024</div>
          <div class="content">
            <span>Social Media</span>
            <h4><a href="blog-details.html">We Launch Pulsar Template this Week!</a></h4>
          </div>
          <a href="#" class="i-btn btn--lg btn--white capsuled">More info<span><i class="bi bi-arrow-up-right"></i></span></a>
          <div class="blog-btn">
          </div>
          <div class="image">
            <img src="https://i.ibb.co/pb0cvp1/blog1.jpg" alt="blog1">
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="blog-style-two">
          <div class="date">10 January, 2024</div>
          <div class="content">
            <span>Social Media</span>
            <h4><a href="blog-details.html">We Launch Pulsar Template this Week!</a></h4>
          </div>
          <a href="#" class="i-btn btn--lg btn--white capsuled">More info<span><i class="bi bi-arrow-up-right"></i></span></a>
          <div class="blog-btn">
          </div>
          <div class="image">
            <img src="https://i.ibb.co/fDGrvZC/blog2.jpg" alt="blog2">
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="blog-style-two">
          <div class="date">10 January, 2024</div>
          <div class="content">
            <span>Social Media</span>
            <h4><a href="blog-details.html">We Launch Pulsar Template this Week!</a></h4>
          </div>
          <a href="#" class="i-btn btn--lg btn--white capsuled">More info<span><i class="bi bi-arrow-up-right"></i></span></a>
          <div class="blog-btn">
          </div>
          <div class="image">
            <img src="https://i.ibb.co/nr0BqCr/blog3.jpg" alt="blog3">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Blog section end -->

<!-- Blog Details section start -->

<section class="blog-details pt-110">
  <div class="container">
    <h3 class="title">Adipiscing lacus dui rutrum quam. In morbi facilisis elit.</h3>
    <ul class="date">
      <li>13 Sept, 2024</li>
      <li>10:52 PM</li>
    </ul>
    <div class="mb-30">
      <img src="https://i.ibb.co/ZHZMVVR/blog-details.jpg" alt="blog-details">
    </div>
    <div class="row gy-5">
      <div class="col-lg-8 pe-lg-5">
        <p class="mb-30">Vestibulum egestas amet, morbi facilisis semper mi placerat ac. Et tristique mus vel eu libero, lacus sit consectetur. Tristique dapibus fringilla in lectus ullamcorper tristique risus id nunc. Enim mi a, sapien velit dolor sagittis. Erat posuere aliquam, sit maecenas a neque lectus commodo scelerisque. Volutpat purus facilisis egestas risus convallis libero morbi est orci. Senectus a senectus cursus consectetur egestas eu fringilla eu phasellus. Tristique mollis velit.</p>
        <h4 class="sub-title mb-3">Adipiscing lacus dui rutrum quam. In morbi facilisis elit.</h4>
        <p class="mb-3">Tincidunt et amet suspendisse venenatis neque ultricies eget. Aliquam duis amet amet lobortis. Elit risus ultrices gravida fringilla id odio tortor, vitae. In pretium purus ac potenti pretium ultrices. Aliquam velit scelerisque auctor in libero amet. Commodo faucibus consequat, dolor fringilla volutpat sed nibh. Amet, sit ut id eget. Egestas hendrerit.</p>
        <p class="mb-60">Tempor lorem diam curabitur ac in nec, elementum arcu. Risus habitasse in aliquet mattis augue augue ornare in. Orci eu maecenas purus diam, sapien facilisis. Nunc tincidunt urna amet, et, in turpis sagittis, tristique purus. Facilisis sagittis nec et egestas leo lorem diam aenean egestas. Cras vestibulum, purus pretium nisl. Diam eleifend egestas gravida cursus in.</p>
        <div class="share-blog">
          <h6>Like what you see? Share with a friend.</h6>
            <div class="footer-social">
              <ul>
                <li><a href="https://www.facebook.com/"><i class="bi bi-facebook"></i></a></li>
                <li><a href="https://twitter.com/"><i class="bi bi-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a></li>
                <li><a href="https://www.youtube.com/"><i class="bi bi-youtube"></i></a></li>
              </ul>
            </div>
        </div>
      </div>
      <div class="col-lg-4">
        <h5 class="mb-4 text-uppercase">Popular Posts</h5>
        <ul class="popular-post-list">
          <li>
            <div class="image">
              <img src="https://i.ibb.co/JyMzzhM/IMAGE-1.jpg" alt="IMAGE-1">
            </div>
            <div class="content">
              <span>Technology</span>
              <h6><a href="blog-details.html">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h6>
            </div>
          </li>
          <li>
            <div class="image">
              <img src="https://i.ibb.co/wWkYg4H/IMAGE-2.jpg" alt="IMAGE-2">
            </div>
            <div class="content">
              <span>SOCIAL</span>
              <h6><a href="blog-details.html">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h6>
            </div>
          </li>
          <li>
            <div class="image">
              <img src="https://i.ibb.co/JyMzzhM/IMAGE-1.jpg" alt="IMAGE-1">
            </div>
            <div class="content">
              <span>Technology</span>
              <h6><a href="blog-details.html">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h6>
            </div>
          </li>
          <li>
            <div class="image">
              <img src="https://i.ibb.co/wWkYg4H/IMAGE-2.jpg" alt="IMAGE-2">
            </div>
            <div class="content">
              <span>Productivity</span>
              <h6><a href="blog-details.html">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h6>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Blog Details section end -->


  @include('frontend.partials.page_section')

@endsection

