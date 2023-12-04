
@php
   $testimonialContent  = get_content("content_testimonial")->first();  
   $testimonialElements = get_content("element_testimonial");  
@endphp


<section class="blog pb-110">
      <div class="container-fluid wrapper-fluid">
        <div class="row g-5">
          <div class="col-xl-3 col-lg-8 col-md-11 col-12">
            <div class="section-title">
              <span>Blogs</span>
              <h3 class="title-anim">Latest News</h3>
              <p>
                Track the engagement rate, comments, likes, shares, and
                impressions for each post, so you know what’s working best for
                your audience. Once you’ve identified your high-performing
                posts, you can share them again.
              </p>
            </div>

            <div>
              <a href="./blog.html" class="learn-more">
                <span class="circle" aria-hidden="true">
                  <span class="icon arrow"> </span>
                </span>
                <span class="button-text">Explore All</span>
              </a>
            </div>
          </div>

          <div class="col-xl-9 col-12">
            <div class="blog-slider-wrapper">
              <div class="blog-preview-next">
                <div class="preview-next">
                  <button class="blog-button-prev">
                    <i class="bi bi-arrow-left"></i>
                  </button>

                  <button class="blog-button-next">
                    <i class="bi bi-arrow-right"></i>
                  </button>
                </div>
              </div>

              <div class="swiper blog-slider">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="blog-item">
                      <div class="blog-img">
                        <img
                          src="./assets/images/blog/blog_1.jpg"
                          alt=""
                          loading="lazy"
                        />

                        <div class="blog-card__pop">
                          <span class="shape shape-left">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="120"
                              height="120"
                              viewBox="0 0 120 120"
                              fill="none"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                              />
                            </svg>
                          </span>
                          <a href="./blog-details.html">
                            <i class="bi bi-arrow-up-right"></i>
                          </a>
                          <span class="shape shape-right">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="120"
                              height="120"
                              viewBox="0 0 120 120"
                              fill="none"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                              />
                            </svg>
                          </span>
                        </div>
                      </div>

                      <div class="blog-content">
                        <div class="blog-meta">
                          <span>July 5, 2020</span>
                          <span>4 min read</span>
                        </div>

                        <a href="./blog-details.html" class="blog-title">
                          <h4>
                            Ways of Lying to Yourself About Your New
                            Relationship.
                          </h4>
                        </a>

                        <ul class="blog-tags">
                          <li>
                            <a href="#">Categories Interactive Resource</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="blog-item">
                      <div class="blog-img">
                        <img
                          src="./assets/images/blog/blog_2.jpg"
                          alt=""
                          loading="lazy"
                        />

                        <div class="blog-card__pop">
                          <span class="shape shape-left">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="120"
                              height="120"
                              viewBox="0 0 120 120"
                              fill="none"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                              />
                            </svg>
                          </span>
                          <a href="./blog-details.html">
                            <i class="bi bi-arrow-up-right"></i>
                          </a>
                          <span class="shape shape-right">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="120"
                              height="120"
                              viewBox="0 0 120 120"
                              fill="none"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                              />
                            </svg>
                          </span>
                        </div>
                      </div>

                      <div class="blog-content">
                        <div class="blog-meta">
                          <span>July 5, 2020</span>
                          <span>4 min read</span>
                        </div>

                        <a href="./blog-details.html" class="blog-title">
                          <h4>
                            Ways of Lying to Yourself About Your New
                            Relationship.
                          </h4>
                        </a>

                        <ul class="blog-tags">
                          <li>
                            <a href="#">Categories Interactive Resource</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="blog-item">
                      <div class="blog-img">
                        <img
                          src="./assets/images/blog/blog_3.jpg"
                          alt=""
                          loading="lazy"
                        />

                        <div class="blog-card__pop">
                          <span class="shape shape-left">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="120"
                              height="120"
                              viewBox="0 0 120 120"
                              fill="none"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                              />
                            </svg>
                          </span>
                          <a href="./blog-details.html">
                            <i class="bi bi-arrow-up-right"></i>
                          </a>
                          <span class="shape shape-right">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="120"
                              height="120"
                              viewBox="0 0 120 120"
                              fill="none"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                              />
                            </svg>
                          </span>
                        </div>
                      </div>

                      <div class="blog-content">
                        <div class="blog-meta">
                          <span>July 5, 2020</span>
                          <span>4 min read</span>
                        </div>

                        <a href="./blog-details.html" class="blog-title">
                          <h4>
                            Ways of Lying to Yourself About Your New
                            Relationship.
                          </h4>
                        </a>

                        <ul class="blog-tags">
                          <li>
                            <a href="#">Categories Interactive Resource</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="blog-item">
                      <div class="blog-img">
                        <img
                          src="./assets/images/blog/blog_4.jpg"
                          alt=""
                          loading="lazy"
                        />

                        <div class="blog-card__pop">
                          <span class="shape shape-left">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="120"
                              height="120"
                              viewBox="0 0 120 120"
                              fill="none"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                              />
                            </svg>
                          </span>
                          <a href="./blog-details.html">
                            <i class="bi bi-arrow-up-right"></i>
                          </a>
                          <span class="shape shape-right">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="120"
                              height="120"
                              viewBox="0 0 120 120"
                              fill="none"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                              />
                            </svg>
                          </span>
                        </div>
                      </div>

                      <div class="blog-content">
                        <div class="blog-meta">
                          <span>July 5, 2020</span>
                          <span>4 min read</span>
                        </div>

                        <a href="./blog-details.html" class="blog-title">
                          <h4>
                            Ways of Lying to Yourself About Your New
                            Relationship.
                          </h4>
                        </a>

                        <ul class="blog-tags">
                          <li>
                            <a href="#">Categories Interactive Resource</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
