@php
   $testimonialContent  = get_content("content_testimonial")->first();  
   $testimonialElements = get_content("element_testimonial");
@endphp


<section class="reviews pb-110">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 mx-auto">
          <div class="section-title text-center">
            <span>{{$testimonialContent->value->sub_title}}</span>

            <h3 class="title-anim">{{$testimonialContent->value->title}}</h3>

            <p>
              {{$testimonialContent->value->description}}
            </p>
          </div>
        </div>
      </div>

      <div class="row g-lg-4 g-0 align-items-center">
        <div class="col-12">
          <div class="review-wrapper">
            <div class="swiper review-slider">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="review-card">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                      <div class="quote-icon quote-one">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          version="1.1"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          x="0"
                          y="0"
                          viewBox="0 0 32 32"
                          style="enable-background: new 0 0 512 512"
                          xml:space="preserve"
                          class=""
                        >
                          <g>
                            <path
                              d="M6.6 19.24c-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69.07-3.77-2.69-7.01-6.28-7.38-1.99-.2-3.97.45-5.44 1.77A7.038 7.038 0 0 0 1 12.43c0 3.3 2.34 6.19 5.6 6.81zM24.71 5.45c-1.98-.2-3.96.45-5.43 1.77a7.037 7.037 0 0 0-2.31 5.21c0 3.3 2.34 6.19 5.6 6.81-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69v-.14c0-3.71-2.73-6.87-6.29-7.24z"
                              opacity="1"
                              data-original="#000000"
                              class=""
                            ></path>
                          </g>
                        </svg>
                      </div>
                      <span class="average-rating"> </span>
                    </div>

                    <div class="quote-icon quote-two">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        x="0"
                        y="0"
                        viewBox="0 0 32 32"
                        style="enable-background: new 0 0 512 512"
                        xml:space="preserve"
                        class=""
                      >
                        <g>
                          <path
                            d="M6.6 19.24c-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69.07-3.77-2.69-7.01-6.28-7.38-1.99-.2-3.97.45-5.44 1.77A7.038 7.038 0 0 0 1 12.43c0 3.3 2.34 6.19 5.6 6.81zM24.71 5.45c-1.98-.2-3.96.45-5.43 1.77a7.037 7.037 0 0 0-2.31 5.21c0 3.3 2.34 6.19 5.6 6.81-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69v-.14c0-3.71-2.73-6.87-6.29-7.24z"
                            opacity="1"
                            data-original="#000000"
                            class=""
                          ></path>
                        </g>
                      </svg>
                    </div>

                    <p>
                      Lorem ipsum dolor sit, amet consectetur adipisicing
                      elit. Quibusdam odit adipisci blanditiis, quas hic
                      voluptas molestias quos nulla dolores, pariatur
                      dolorem atque? Vero.
                    </p>

                    <div class="reviewer-meta">
                      <span class="reviewer-img">
                        <img src="./assets/images/user.jpg" alt="" />
                      </span>
                      <div>
                        <h6>Sam Wister</h6>
                        <span>Social media Manager</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="review-card">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                      <div class="quote-icon quote-one">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          version="1.1"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          x="0"
                          y="0"
                          viewBox="0 0 32 32"
                          style="enable-background: new 0 0 512 512"
                          xml:space="preserve"
                          class=""
                        >
                          <g>
                            <path
                              d="M6.6 19.24c-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69.07-3.77-2.69-7.01-6.28-7.38-1.99-.2-3.97.45-5.44 1.77A7.038 7.038 0 0 0 1 12.43c0 3.3 2.34 6.19 5.6 6.81zM24.71 5.45c-1.98-.2-3.96.45-5.43 1.77a7.037 7.037 0 0 0-2.31 5.21c0 3.3 2.34 6.19 5.6 6.81-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69v-.14c0-3.71-2.73-6.87-6.29-7.24z"
                              opacity="1"
                              data-original="#000000"
                              class=""
                            ></path>
                          </g>
                        </svg>
                      </div>
                      <span class="average-rating"> </span>
                    </div>

                    <div class="quote-icon quote-two">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        x="0"
                        y="0"
                        viewBox="0 0 32 32"
                        style="enable-background: new 0 0 512 512"
                        xml:space="preserve"
                        class=""
                      >
                        <g>
                          <path
                            d="M6.6 19.24c-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69.07-3.77-2.69-7.01-6.28-7.38-1.99-.2-3.97.45-5.44 1.77A7.038 7.038 0 0 0 1 12.43c0 3.3 2.34 6.19 5.6 6.81zM24.71 5.45c-1.98-.2-3.96.45-5.43 1.77a7.037 7.037 0 0 0-2.31 5.21c0 3.3 2.34 6.19 5.6 6.81-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69v-.14c0-3.71-2.73-6.87-6.29-7.24z"
                            opacity="1"
                            data-original="#000000"
                            class=""
                          ></path>
                        </g>
                      </svg>
                    </div>

                    <p>
                      Lorem ipsum dolor sit, amet consectetur adipisicing
                      elit. Quibusdam odit adipisci blanditiis, quas hic
                      voluptas molestias quos nulla dolores, pariatur
                      dolorem atque? Vero.
                    </p>

                    <div class="reviewer-meta">
                      <span class="reviewer-img">
                        <img src="./assets/images/user.jpg" alt="" />
                      </span>
                      <div>
                        <h6>Sam Wister</h6>
                        <span>Social media Manager</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="review-card">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                      <div class="quote-icon quote-one">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          version="1.1"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          x="0"
                          y="0"
                          viewBox="0 0 32 32"
                          style="enable-background: new 0 0 512 512"
                          xml:space="preserve"
                          class=""
                        >
                          <g>
                            <path
                              d="M6.6 19.24c-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69.07-3.77-2.69-7.01-6.28-7.38-1.99-.2-3.97.45-5.44 1.77A7.038 7.038 0 0 0 1 12.43c0 3.3 2.34 6.19 5.6 6.81zM24.71 5.45c-1.98-.2-3.96.45-5.43 1.77a7.037 7.037 0 0 0-2.31 5.21c0 3.3 2.34 6.19 5.6 6.81-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69v-.14c0-3.71-2.73-6.87-6.29-7.24z"
                              opacity="1"
                              data-original="#000000"
                              class=""
                            ></path>
                          </g>
                        </svg>
                      </div>
                      <span class="average-rating"> </span>
                    </div>

                    <div class="quote-icon quote-two">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        x="0"
                        y="0"
                        viewBox="0 0 32 32"
                        style="enable-background: new 0 0 512 512"
                        xml:space="preserve"
                        class=""
                      >
                        <g>
                          <path
                            d="M6.6 19.24c-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69.07-3.77-2.69-7.01-6.28-7.38-1.99-.2-3.97.45-5.44 1.77A7.038 7.038 0 0 0 1 12.43c0 3.3 2.34 6.19 5.6 6.81zM24.71 5.45c-1.98-.2-3.96.45-5.43 1.77a7.037 7.037 0 0 0-2.31 5.21c0 3.3 2.34 6.19 5.6 6.81-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69v-.14c0-3.71-2.73-6.87-6.29-7.24z"
                            opacity="1"
                            data-original="#000000"
                            class=""
                          ></path>
                        </g>
                      </svg>
                    </div>

                    <p>
                      Lorem ipsum dolor sit, amet consectetur adipisicing
                      elit. Quibusdam odit adipisci blanditiis, quas hic
                      voluptas molestias quos nulla dolores, pariatur
                      dolorem atque? Vero.
                    </p>

                    <div class="reviewer-meta">
                      <span class="reviewer-img">
                        <img src="./assets/images/user.jpg" alt="" />
                      </span>
                      <div>
                        <h6>Sam Wister</h6>
                        <span>Social media Manager</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="review-card">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                      <div class="quote-icon quote-one">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          version="1.1"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          x="0"
                          y="0"
                          viewBox="0 0 32 32"
                          style="enable-background: new 0 0 512 512"
                          xml:space="preserve"
                          class=""
                        >
                          <g>
                            <path
                              d="M6.6 19.24c-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69.07-3.77-2.69-7.01-6.28-7.38-1.99-.2-3.97.45-5.44 1.77A7.038 7.038 0 0 0 1 12.43c0 3.3 2.34 6.19 5.6 6.81zM24.71 5.45c-1.98-.2-3.96.45-5.43 1.77a7.037 7.037 0 0 0-2.31 5.21c0 3.3 2.34 6.19 5.6 6.81-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69v-.14c0-3.71-2.73-6.87-6.29-7.24z"
                              opacity="1"
                              data-original="#000000"
                              class=""
                            ></path>
                          </g>
                        </svg>
                      </div>
                      <span class="average-rating"> </span>
                    </div>

                    <div class="quote-icon quote-two">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        x="0"
                        y="0"
                        viewBox="0 0 32 32"
                        style="enable-background: new 0 0 512 512"
                        xml:space="preserve"
                        class=""
                      >
                        <g>
                          <path
                            d="M6.6 19.24c-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69.07-3.77-2.69-7.01-6.28-7.38-1.99-.2-3.97.45-5.44 1.77A7.038 7.038 0 0 0 1 12.43c0 3.3 2.34 6.19 5.6 6.81zM24.71 5.45c-1.98-.2-3.96.45-5.43 1.77a7.037 7.037 0 0 0-2.31 5.21c0 3.3 2.34 6.19 5.6 6.81-.66 1.66-1.7 3.3-3.09 4.88-.44.5-.5 1.22-.14 1.78.28.44.74.68 1.24.68.14 0 .28-.01.42-.06 2.94-.86 9.81-3.91 10-13.69v-.14c0-3.71-2.73-6.87-6.29-7.24z"
                            opacity="1"
                            data-original="#000000"
                            class=""
                          ></path>
                        </g>
                      </svg>
                    </div>

                    <p>
                      Lorem ipsum dolor sit, amet consectetur adipisicing
                      elit. Quibusdam odit adipisci blanditiis, quas hic
                      voluptas molestias quos nulla dolores, pariatur
                      dolorem atque? Vero.
                    </p>

                    <div class="reviewer-meta">
                      <span class="reviewer-img">
                        <img src="./assets/images/user.jpg" alt="" />
                      </span>
                      <div>
                        <h6>Sam Wister</h6>
                        <span>Social media Manager</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>