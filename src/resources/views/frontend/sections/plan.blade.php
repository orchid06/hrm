
@php
   $content             = get_content("content_plan")->first();  
@endphp


<section class="plan pt-110 pb-110">
    <div class="container">
      <div class="row gy-5">
        <div class="col-xl-5 col-lg-4">
          <div>
            <div class="section-title">
              <span>{{$content->value->sub_title}}</span>

              <h3 class="title-anim">{{$content->value->title}}</h3>
  
              <p>
                {{$content->value->description}}
              </p>
            </div>

            <div class="d-flex align-items-center gap-4">
              <a href="{{url($content->value->button_url)}}" class="i-btn btn--secondary btn--lg capsuled">
                {{$content->value->button_name}}
              </a>
            </div>
          </div>
        </div>

        <div class="col-xl-7 col-lg-8">
          <div
            class="d-flex align-items-center justify-content-between flex-wrap gap-4 mb-4"
          >
            <div class="nav plan-tab" role="tablist">
              <button
                class="nav-link active"
                id="monthly-tab"
                data-bs-toggle="pill"
                data-bs-target="#monthly"
                type="button"
                role="tab"
                aria-controls="monthly"
                aria-selected="true"
              >
                Monthly
              </button>

              <button
                class="nav-link"
                id="yearly-tab"
                data-bs-toggle="pill"
                data-bs-target="#yearly"
                type="button"
                role="tab"
                aria-controls="yearly"
                aria-selected="false"
              >
                Yearly
              </button>
            </div>

            <a href="#" class="learn-more">
              <span class="circle" aria-hidden="true">
                <span class="icon arrow"> </span>
              </span>
              <span class="button-text">Explore All</span>
            </a>
          </div>

          <div class="tab-content" id="tab-plans">
            <div
              class="tab-pane fade show active"
              id="monthly"
              role="tabpanel"
              aria-labelledby="monthly-tab"
              tabindex="0"
            >
              <div class="row g-4">
                <div class="col-md-7 order-md-0 order-1">
                  <div class="tab-content" id="price-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="plan-month-intro"
                      role="tabpanel"
                      aria-labelledby="plan-month-intro-tab"
                    >
                      <div class="plan-card-detail">
                        <p>
                          Lorem ipsum dolor sit amet, consectetur
                          adipisicing elit. Neque, eos hic commodi nisi
                          minima sit.
                        </p>
                        <ul>
                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>5 social profiles</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Publish, schedule, draft and queue posts</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Social content calendar</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Suggestions by AI Assist</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>
                        </ul>
                        <div>
                          <a
                            href="#"
                            class="i-btn btn--secondary btn--lg capsuled"
                          >
                            Start your free trial
                          </a>
                        </div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="paln-month-base"
                      role="tabpanel"
                      aria-labelledby="paln-month-base-tab"
                    >
                      <div class="plan-card-detail">
                        <p>
                          Lorem ipsum dolor sit amet, consectetur
                          adipisicing elit. Neque, eos hic commodi nisi
                          minima sit.
                        </p>
                        <ul>
                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>8 social profiles</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Publish, schedule, draft and queue posts</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Social content calendar</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Suggestions by AI Assist</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>
                        </ul>
                        <div>
                          <a
                            href="#"
                            class="i-btn btn--secondary btn--lg capsuled"
                          >
                            Start your free trial
                          </a>
                        </div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="paln-month-popular"
                      role="tabpanel"
                      aria-labelledby="paln-month-popular-tab"
                    >
                      <div class="plan-card-detail">
                        <p>
                          Lorem ipsum dolor sit amet, consectetur
                          adipisicing elit. Neque, eos hic commodi nisi
                          minima sit.
                        </p>
                        <ul>
                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>10 social profiles</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Publish, schedule, draft and queue posts</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Social content calendar</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Suggestions by AI Assist</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>
                        </ul>
                        <div>
                          <a
                            href="#"
                            class="i-btn btn--secondary btn--lg capsuled"
                          >
                            Start your free trial
                          </a>
                        </div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="plan-month-enterprise"
                      role="tabpanel"
                      aria-labelledby="plan-month-enterprise-tab"
                    >
                      <div class="plan-card-detail">
                        <p>
                          Lorem ipsum dolor sit amet, consectetur
                          adipisicing elit. Neque, eos hic commodi nisi
                          minima sit.
                        </p>
                        <ul>
                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>12 social profiles</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Publish, schedule, draft and queue posts</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Social content calendar</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Suggestions by AI Assist</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>
                        </ul>
                        <div>
                          <a
                            href="#"
                            class="i-btn btn--secondary btn--lg capsuled"
                          >
                            Start your free trial
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-5 order-md-1 order-0">
                  <div
                    class="nav plan-card-list"
                    role="tablist"
                    aria-orientation="vertical"
                  >
                    <a
                      class="nav-link plan-card-item active"
                      id="plan-month-intro-tab"
                      data-bs-toggle="pill"
                      href="#plan-month-intro"
                      role="tab"
                      aria-controls="plan-month-intro"
                      aria-selected="true"
                    >
                      <div class="plan-card-left">
                        <span>Intro</span>
                        <h4><del>$30</del> $19 <span>/Month</span></h4>
                      </div>

                      <div class="plan-card-right">
                        <span> </span>
                      </div>
                    </a>

                    <a
                      class="nav-link plan-card-item"
                      id="paln-month-base-tab"
                      data-bs-toggle="pill"
                      href="#paln-month-base"
                      role="tab"
                      aria-controls="paln-month-base"
                      aria-selected="false"
                      tabindex="-1"
                    >
                      <div class="plan-card-left">
                        <span>Base</span>
                        <h4><del>$30</del> $19 <span>/Month</span></h4>
                      </div>

                      <div class="plan-card-right">
                        <span> </span>
                      </div>
                    </a>

                    <a
                      class="nav-link plan-card-item"
                      id="paln-month-popular-tab"
                      data-bs-toggle="pill"
                      href="#paln-month-popular"
                      role="tab"
                      aria-controls="paln-month-popular"
                      aria-selected="false"
                      tabindex="-1"
                    >
                      <div class="plan-card-left">
                        <span>Popular</span>
                        <h4><del>$30</del> $19 <span>/Month</span></h4>
                      </div>

                      <div class="plan-card-right">
                        <span> </span>
                      </div>
                    </a>

                    <a
                      class="nav-link plan-card-item"
                      id="plan-month-enterprise-tab"
                      data-bs-toggle="pill"
                      href="#plan-month-enterprise"
                      role="tab"
                      aria-controls="plan-month-enterprise"
                      aria-selected="false"
                      tabindex="-1"
                    >
                      <div class="plan-card-left">
                        <span>Enterprise</span>
                        <h4><del>$30</del> $19 <span>/Month</span></h4>
                      </div>

                      <div class="plan-card-right">
                        <span> </span>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="tab-pane fade"
              id="yearly"
              role="tabpanel"
              aria-labelledby="yearly-tab"
              tabindex="0"
            >
              <div class="row g-4">
                <div class="col-md-7 order-md-0 order-1">
                  <div class="tab-content" id="price-tabContent-two">
                    <div
                      class="tab-pane fade show active"
                      id="plan-yearly-intro"
                      role="tabpanel"
                      aria-labelledby="plan-yearly-intro-tab"
                    >
                      <div class="plan-card-detail">
                        <p>
                          Lorem ipsum dolor sit amet, consectetur
                          adipisicing elit. Neque, eos hic commodi nisi
                          minima sit.
                        </p>
                        <ul>
                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>5 social profiles</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Publish, schedule, draft and queue posts</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Social content calendar</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Suggestions by AI Assist</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>
                        </ul>
                        <div>
                          <a
                            href="#"
                            class="i-btn btn--secondary btn--lg capsuled"
                          >
                            Start your free trial
                          </a>
                        </div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="paln-yearly-base"
                      role="tabpanel"
                      aria-labelledby="paln-yearly-base-tab"
                    >
                      <div class="plan-card-detail">
                        <p>
                          Lorem ipsum dolor sit amet, consectetur
                          adipisicing elit. Neque, eos hic commodi nisi
                          minima sit.
                        </p>
                        <ul>
                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>8 social profiles</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Publish, schedule, draft and queue posts</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Social content calendar</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Suggestions by AI Assist</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>
                        </ul>
                        <div>
                          <a
                            href="#"
                            class="i-btn btn--secondary btn--lg capsuled"
                          >
                            Start your free trial
                          </a>
                        </div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="paln-yearly-popular"
                      role="tabpanel"
                      aria-labelledby="paln-yearly-popular-tab"
                    >
                      <div class="plan-card-detail">
                        <p>
                          Lorem ipsum dolor sit amet, consectetur
                          adipisicing elit. Neque, eos hic commodi nisi
                          minima sit.
                        </p>
                        <ul>
                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>10 social profiles</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Publish, schedule, draft and queue posts</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Social content calendar</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Suggestions by AI Assist</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>
                        </ul>
                        <div>
                          <a
                            href="#"
                            class="i-btn btn--secondary btn--lg capsuled"
                          >
                            Start your free trial
                          </a>
                        </div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="plan-yearly-enterprise"
                      role="tabpanel"
                      aria-labelledby="plan-yearly-enterprise-tab"
                    >
                      <div class="plan-card-detail">
                        <p>
                          Lorem ipsum dolor sit amet, consectetur
                          adipisicing elit. Neque, eos hic commodi nisi
                          minima sit.
                        </p>

                        <ul>
                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>12 social profiles</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Publish, schedule, draft and queue posts</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Social content calendar</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>Suggestions by AI Assist</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>

                          <li>
                            <span>
                              <i class="bi bi-patch-check"></i>
                            </span>
                            <p>All-in-one social inbox</p>
                          </li>
                        </ul>
                        <div>
                          <a
                            href="#"
                            class="i-btn btn--secondary btn--lg capsuled"
                          >
                            Start your free trial
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-5 order-md-1 order-0">
                  <div
                    class="nav plan-card-list"
                    role="tablist"
                    aria-orientation="vertical"
                  >
                    <a
                      class="nav-link plan-card-item active"
                      id="plan-yearly-intro-tab"
                      data-bs-toggle="pill"
                      href="#plan-yearly-intro"
                      role="tab"
                      aria-controls="plan-yearly-intro"
                      aria-selected="true"
                    >
                      <div class="plan-card-left">
                        <span>Intro</span>
                        <h4><del>$30</del> $19 <span>/Month</span></h4>
                      </div>

                      <div class="plan-card-right">
                        <span> </span>
                      </div>
                    </a>

                    <a
                      class="nav-link plan-card-item"
                      id="paln-yearly-base-tab"
                      data-bs-toggle="pill"
                      href="#paln-yearly-base"
                      role="tab"
                      aria-controls="paln-yearly-base"
                      aria-selected="false"
                      tabindex="-1"
                    >
                      <div class="plan-card-left">
                        <span>Base</span>
                        <h4><del>$30</del> $19 <span>/Month</span></h4>
                      </div>

                      <div class="plan-card-right">
                        <span> </span>
                      </div>
                    </a>

                    <a
                      class="nav-link plan-card-item"
                      id="paln-yearly-popular-tab"
                      data-bs-toggle="pill"
                      href="#paln-yearly-popular"
                      role="tab"
                      aria-controls="paln-yearly-popular"
                      aria-selected="false"
                      tabindex="-1"
                    >
                      <div class="plan-card-left">
                        <span>Popular</span>
                        <h4><del>$30</del> $19 <span>/Month</span></h4>
                      </div>

                      <div class="plan-card-right">
                        <span> </span>
                      </div>
                    </a>

                    <a
                      class="nav-link plan-card-item"
                      id="plan-yearly-enterprise-tab"
                      data-bs-toggle="pill"
                      href="#plan-yearly-enterprise"
                      role="tab"
                      aria-controls="plan-yearly-enterprise"
                      aria-selected="false"
                      tabindex="-1"
                    >
                      <div class="plan-card-left">
                        <span>Enterprise</span>
                        <h4><del>$30</del> $19 <span>/Month</span></h4>
                      </div>

                      <div class="plan-card-right">
                        <span> </span>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>