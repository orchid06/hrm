@php
    $testimonialContent    = get_content("content_testimonial")->first();
    $testimonialElements   = get_content("element_testimonial");

    $featureImageSize      = get_appearance_img_size('testimonial','element','image');

@endphp






<section class="reviews pb-110">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="section-title-one text-center mb-60">
                    <div class="subtitle">{{$testimonialContent->value->sub_title}}</div>
                    <h2>  @php echo @$testimonialContent->value->title @endphp </h2>
                    <p>{{$testimonialContent->value->description}}.</p>
                </div>
            </div>
        </div>

        <div class="row g-lg-4 g-0 align-items-center">
            <div class="col-12">
                 @if($testimonialElements->count() > 0)
                        <div class="review-wrapper">
                            <div class="shape-radius-one">
                                <img src="{{asset('assets/images/default/template_shape.png')}}" alt="shape.png">
                            </div>
                            <div class="shape-radius-two">
                                <img src="{{asset('assets/images/default/template_shape.png')}}" alt="shape.png">
                            </div>
                            <div class="swiper review-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($testimonialElements as $testimonial)
                                        <div class="swiper-slide">
                                            <div class="review-card">
                                                <div class="quote-icon quote-one">
                                                    <i class="bi bi-quote"></i>
                                                </div>
                                                <div
                                                    class="d-flex flex-row justify-content-start align-items-stretch flex-md-nowrap flex-wrap gap-0">
                                                    <div class="review-image">
                                                        @php $file = $testimonial->file?->first(); @endphp
                                                        <img src="{{imageURL($file,'frontend',true,$featureImageSize)}}" alt="{{@$file->name?? "author.jpg"}}">
                                                    </div>
                                                    <div class="review-content">
                                                        <ul class="review-rating d-flex align-items-center gap-1">
                                                            @php echo show_ratings($testimonial->value->rating) @endphp
                                                        </ul>
                                                        <p>
                                                        {{$testimonial->value->quote}}
                                                        </p>
                                                        <div class="reviewer-meta">
                                                            <h6>{{$testimonial->value->author}}</h6>
                                                            <span>{{$testimonial->value->designation}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                        
                                </div>
                            </div>
                            <div class="review-arrow-wrapper">
                                <div class="review-button-prev"><i class="bi bi-arrow-left"></i></div>
                                <div class="review-button-next"><i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                @else
                       @include("frontend.partials.not_found")
                @endif
            </div>
        </div>
    </div>
</section>



<section class="service-details-section pt-110 pb-110">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-8">
                <div class="service-d-image mb-30">
                    <img src="https://i.ibb.co/9Zzf60Q/service-d.jpg" alt="service-d">
                </div>
                <div class="service-details">
                    <h2 class="mb-3">Advanced AI-Powered Engagement, Content Personalization, and User Experience
                        Enhancement Platform</h2>
                    <p class="mb-3"> Utilizing state-of-the-art AI technology, the platform delivers highly customized
                        content, enhancing user experience by presenting the most pertinent and engaging posts.
                        Intelligent algorithms adapt to each user's preferences, fostering stronger connections and a
                        sense of community. This innovative platform sets a new benchmark for social media, making it
                        more personalized, interactive, and user-centric, ultimately transforming the way users engage
                        and connect online.</p>
                    <ul>
                        <li><i class="bi bi-check2-circle"></i>Leveraging AI to ensure users see the most relevant and
                            engaging posts tailored to their interests.</li>
                        <li><i class="bi bi-check2-circle"></i>Continuously adapting to individual preferences to
                            enhance user experience and foster deeper connections.</li>
                        <li><i class="bi bi-check2-circle"></i>Promoting interactive and meaningful interactions through
                            AI-driven features.</li>
                        <li><i class="bi bi-check2-circle"></i>Creating stronger community bonds by understanding and
                            catering to user behaviors and preferences.</li>
                        <li><i class="bi bi-check2-circle"></i>Setting a new standard in social media with a focus on
                            seamless, intuitive, and dynamic user experiences.</li>
                    </ul>
                    <h4 class="mb-3">Adipiscing lacus dui rutrum quam. In morbi facilisis elit.</h4>
                    <p>This platform employs cutting-edge AI to provide users with highly personalized content, ensuring
                        they encounter the most relevant and engaging posts tailored to their interests. Its intelligent
                        algorithms continuously adapt to individual user preferences, fostering deeper connections and a
                        stronger sense of community. By enhancing user experience through seamless and intuitive
                        interactions, this platform sets a new standard for social media, making it more engaging,
                        user-centric, and dynamic. It ultimately reshapes how users connect, share, and interact in the
                        digital world.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar-wigt mb-4">
                    <h4>Other Services</h4>
                    <ul>
                        <li><a href="#"><i class="bi bi-caret-right-fill"></i>Image and video content curation.</a></li>
                        <li><a href="#"><i class="bi bi-caret-right-fill"></i>Tweet recommendation spam.</a></li>
                        <li><a href="#"><i class="bi bi-caret-right-fill"></i>Job matching personalized.</a></li>
                        <li><a href="#"><i class="bi bi-caret-right-fill"></i>Video content recommendation.</a></li>
                        <li><a href="#"><i class="bi bi-caret-right-fill"></i>Video recommendation processing.</a></li>
                    </ul>
                </div>
                <div class="sidebar-wigt">
                    <h4>Contact Us</h4>
                    <form class="w-100" 0>
                        <div class="form-inner">
                            <input type="text" placeholder="Enter Full Name">
                        </div>
                        <div class="form-inner">
                            <input type="email" placeholder="Enter Email">
                        </div>
                        <div class="form-inner">
                            <textarea placeholder="Write Message"></textarea>
                        </div>
                        <button type="submit" class="i-btn btn--lg btn--primary capsuled w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



