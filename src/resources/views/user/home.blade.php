@extends('layouts.master')
@section('content')

    <div class="row g-4">
      <div class="col-12">
        <div class="dash-intro">
          <div class="row align-items-center gx-4 gy-5">
            <div class="col-xxl-4 col-xl-4">
              <div class="dash-intro-content">
                <h3>Welcome, Scott Warner</h3>
                <p>
                  Stay on top of your social hive by creating and scheduling
                  posts consistently.
                </p>
              </div>
            </div>

            <div class="col-xxl-8">
              <div class="posting-summary">
                <div class="row g-4">
                  <div class="col-lg-3 col-sm-6">
                    <div class="summary-card">
                      <span>
                        <i class="bi bi-hourglass-split"></i>
                      </span>

                      <div>
                        <h6>1</h6>
                        <p>Queued</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-3 col-sm-6">
                    <div class="summary-card">
                      <span>
                        <i class="bi bi-calendar-check"></i>
                      </span>

                      <div>
                        <h6>1</h6>
                        <p>Published</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-3 col-sm-6">
                    <div class="summary-card">
                      <span>
                        <i class="bi bi-calendar-x"></i>
                      </span>

                      <div>
                        <h6>1</h6>
                        <p>Unschedule</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-3 col-sm-6">
                    <div class="summary-card">
                      <span>
                        <i class="bi bi-journal-x"></i>
                      </span>

                      <div>
                        <h6>1</h6>
                        <p>Failed</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="i-card-md card-height-100 plan-upgrade-card">
          <div class="card-body plan-upgrade-body">
            <div class="existing-plan">
              <div class="dot-spinner">
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
              </div>

              Popular/Yearly
            </div>
            <h3>Try our all new Enviroment with Pro Plan</h3>

            <a
              href="./plan.html"
              class="i-btn btn--primary btn--lg capsuled"
            >
              Upgrade Now
            </a>

            <div class="plan-upgrade-img">
              <img
                src="./assets/images/paln.gif"
                alt=""
                class="img-fluid"
              />
            </div>
          </div>

          <div class="plan-upgrade-bg">
            <img src="./assets/images/plan-upgrade.png" alt="" />
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">Connected Account</h4>
            <div>
              <a href="#" class="i-btn info btn--sm capsuled">See all</a>
            </div>
          </div>

          <div class="card-body">
            <ul class="channel-list">
              <li>
                <div class="channel-item">
                  <div class="channel-meta">
                    <span class="channel-img">
                      <img
                        src="./assets/images/social-logo/facebook.png"
                        alt=""
                      />
                    </span>

                    <div class="channel-info">
                      <h5>Facebook</h5>
                    </div>
                  </div>

                  <div class="channel-action">
                    <a
                      href="#"
                      class="i-btn btn--primary-outline btn--sm capsuled"
                      >2 Profile
                    </a>
                  </div>
                </div>
              </li>

              <li>
                <div class="channel-item">
                  <div class="channel-meta">
                    <span class="channel-img">
                      <img
                        src="./assets/images/social-logo/instagram.png"
                        alt=""
                      />
                    </span>

                    <div class="channel-info">
                      <h5>Facebook</h5>
                    </div>
                  </div>

                  <div class="channel-action">
                    <a
                      href="#"
                      class="i-btn btn--primary-outline btn--sm capsuled"
                      >2 Profile
                    </a>
                  </div>
                </div>
              </li>

              <li>
                <div class="channel-item">
                  <div class="channel-meta">
                    <span class="channel-img">
                      <img
                        src="./assets/images/social-logo/linkedin.png"
                        alt=""
                      />
                    </span>

                    <div class="channel-info">
                      <h5>Facebook</h5>
                    </div>
                  </div>

                  <div class="channel-action">
                    <a
                      href="#"
                      class="i-btn btn--primary-outline btn--sm capsuled"
                      >2 Profile
                    </a>
                  </div>
                </div>
              </li>

              <li>
                <div class="channel-item">
                  <div class="channel-meta">
                    <span class="channel-img">
                      <img
                        src="./assets/images/social-logo/youtube.png"
                        alt=""
                      />
                    </span>

                    <div class="channel-info">
                      <h5>Facebook</h5>
                    </div>
                  </div>

                  <div class="channel-action">
                    <a
                      href="#"
                      class="i-btn btn--primary-outline btn--sm capsuled"
                      >2 Profile
                    </a>
                  </div>
                </div>
              </li>

              <li>
                <div class="channel-item">
                  <div class="channel-meta">
                    <span class="channel-img">
                      <img
                        src="./assets/images/social-logo/tik-tok.png"
                        alt=""
                      />
                    </span>

                    <div class="channel-info">
                      <h5>Facebook</h5>
                    </div>
                  </div>

                  <div class="channel-action">
                    <a
                      href="#"
                      class="i-btn btn--primary-outline btn--sm capsuled"
                      >2 Profile
                    </a>
                  </div>
                </div>
              </li>

              <li>
                <div class="channel-item">
                  <div class="channel-meta">
                    <span class="channel-img">
                      <img
                        src="./assets/images/social-logo/facebook.png"
                        alt=""
                      />
                    </span>

                    <div class="channel-info">
                      <h5>Facebook</h5>
                    </div>
                  </div>

                  <div class="channel-action">
                    <a
                      href="#"
                      class="i-btn btn--primary-outline btn--sm capsuled"
                      >2 Profile
                    </a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">Latest Content Insights</h4>
            <div class="d-flex align-items-center gap-3">
              <button class="post-prev icon-btn icon-btn-md primary circle">
                <i class="bi bi-chevron-left"></i>
              </button>

              <a href="#" class="i-btn info btn--sm capsuled">See all</a>

              <button class="post-next icon-btn icon-btn-md primary circle">
                <i class="bi bi-chevron-right"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="posts-wrap">
              <div class="swiper post-slider">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="post-item">
                      <a href="#" class="post-profile-wrap">
                        <div class="post-profile">
                          <div class="profile-img">
                            <img src="./assets/images/user.jpg" alt="" />
                          </div>

                          <div class="channel-img">
                            <img
                              src="./assets/images/social-logo/instagram.png"
                              alt=""
                            />
                          </div>
                        </div>
                        <div>
                          <p class="profile-name">md_kamrul33417</p>
                          <span>26 Sep, 2023 - 11.00 AM</span>
                        </div>
                      </a>

                      <div class="post-caption">
                        <div class="post-caption-img">
                          <img
                            src="./assets/images/caption-img.jpg"
                            alt=""
                          />
                        </div>
                        <p class="post-caption-text">
                          The primary colorSet from which other elements
                          also inherits is defined in the root colors
                          property. To set colors globally for all charts,
                          use
                        </p>
                      </div>

                      <div class="post-bottom">
                        <div class="post-insight">
                          <p>Likes</p>
                          <h6>1K</h6>
                        </div>

                        <div class="post-insight">
                          <p>Comments</p>
                          <h6>320</h6>
                        </div>

                        <div class="post-insight">
                          <p>Share</p>
                          <h6>280</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="post-item">
                      <a href="#" class="post-profile-wrap">
                        <div class="post-profile">
                          <div class="profile-img">
                            <img src="./assets/images/user.jpg" alt="" />
                          </div>

                          <div class="channel-img">
                            <img
                              src="./assets/images/social-logo/instagram.png"
                              alt=""
                            />
                          </div>
                        </div>
                        <div>
                          <p class="profile-name">md_kamrul33417</p>
                          <span>26 Sep, 2023 - 11.00 AM</span>
                        </div>
                      </a>

                      <div class="post-caption">
                        <div class="post-caption-img">
                          <img
                            src="./assets/images/caption-img.jpg"
                            alt=""
                          />
                        </div>
                        <p class="post-caption-text">
                          The primary colorSet from which other elements
                          also inherits is defined in the root colors
                          property. To set colors globally for all charts,
                          use
                        </p>
                      </div>

                      <div class="post-bottom">
                        <div class="post-insight">
                          <p>Likes</p>
                          <h6>1K</h6>
                        </div>

                        <div class="post-insight">
                          <p>Comments</p>
                          <h6>320</h6>
                        </div>

                        <div class="post-insight">
                          <p>Share</p>
                          <h6>280</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="post-item">
                      <a href="#" class="post-profile-wrap">
                        <div class="post-profile">
                          <div class="profile-img">
                            <img src="./assets/images/user.jpg" alt="" />
                          </div>

                          <div class="channel-img">
                            <img
                              src="./assets/images/social-logo/instagram.png"
                              alt=""
                            />
                          </div>
                        </div>
                        <div>
                          <p class="profile-name">md_kamrul33417</p>
                          <span>26 Sep, 2023 - 11.00 AM</span>
                        </div>
                      </a>

                      <div class="post-caption">
                        <div class="post-caption-img">
                          <img
                            src="./assets/images/caption-img.jpg"
                            alt=""
                          />
                        </div>
                        <p class="post-caption-text">
                          The primary colorSet from which other elements
                          also inherits is defined in the root colors
                          property. To set colors globally for all charts,
                          use
                        </p>
                      </div>

                      <div class="post-bottom">
                        <div class="post-insight">
                          <p>Likes</p>
                          <h6>1K</h6>
                        </div>

                        <div class="post-insight">
                          <p>Comments</p>
                          <h6>320</h6>
                        </div>

                        <div class="post-insight">
                          <p>Share</p>
                          <h6>280</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="post-item">
                      <a href="#" class="post-profile-wrap">
                        <div class="post-profile">
                          <div class="profile-img">
                            <img src="./assets/images/user.jpg" alt="" />
                          </div>

                          <div class="channel-img">
                            <img
                              src="./assets/images/social-logo/instagram.png"
                              alt=""
                            />
                          </div>
                        </div>
                        <div>
                          <p class="profile-name">md_kamrul33417</p>
                          <span>26 Sep, 2023 - 11.00 AM</span>
                        </div>
                      </a>

                      <div class="post-caption">
                        <div class="post-caption-img">
                          <img
                            src="./assets/images/caption-img.jpg"
                            alt=""
                          />
                        </div>
                        <p class="post-caption-text">
                          The primary colorSet from which other elements
                          also inherits is defined in the root colors
                          property. To set colors globally for all charts,
                          use
                        </p>
                      </div>

                      <div class="post-bottom">
                        <div class="post-insight">
                          <p>Likes</p>
                          <h6>1K</h6>
                        </div>

                        <div class="post-insight">
                          <p>Comments</p>
                          <h6>320</h6>
                        </div>

                        <div class="post-insight">
                          <p>Share</p>
                          <h6>280</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="i-card-md">
          <div class="card-header">
            <h4 class="card-title">Insight</h4>
          </div>
          <div class="card-body">
            <div id="apexarea-2" class="apex-chart"></div>
          </div>
        </div>
      </div>

      <div class="col-xl-4">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">Report post by type</h4>
          </div>
          <div class="card-body">
            <div id="pieChartTwo" class="apex-chart"></div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="i-card-md">
          <div class="card-header">
            <h4 class="card-title">Latest Payment Log</h4>
            <div class="d-flex align-items-center gap-3">
              <button class="i-btn danger btn--sm capsuled">
                <i class="bi bi-card-list"></i> Generate Report
              </button>
              <button
                class="icon-btn icon-btn-lg info circle"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#tableFilter"
                aria-expanded="false"
                aria-controls="tableFilter"
              >
                <i class="bi bi-funnel"></i>
              </button>
            </div>
          </div>

          <div class="collapse" id="tableFilter">
            <div class="search-action-area">
              <div class="search-area">
                <form action="#">
                  <div class="form-inner">
                    <input type="search" placeholder="Your Query" />
                    <div class="search-icon">
                      <i class="bi bi-search"></i>
                    </div>
                  </div>

                  <div class="form-inner">
                    <select class="form-select niceSelect">
                      <option value>--Please choose an option--</option>
                      <option value="dog">Dog</option>
                      <option value="cat">Cat</option>
                      <option value="hamster">Hamster</option>
                      <option value="parrot">Parrot</option>
                      <option value="spider">Spider</option>
                      <option value="goldfish">Goldfish</option>
                    </select>
                  </div>

                  <div>
                    <button class="i-btn primary btn--lg">
                      <i class="bi bi-search"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="card-body px-0">
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th scope="col">
                      <input
                        class="form-check-input checkAll"
                        type="checkbox"
                      />
                    </th>
                    <th scope="col">Customer</th>
                    <th scope="col">Payment type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Status Two</th>
                    <th scope="col">Date</th>
                    <th scope="col">Expire</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <td data-label="Transaction ID">
                      <input class="form-check-input" type="checkbox" />
                    </td>
                    <td data-label="Customer">
                      <div class="user-meta-info">
                        <p>Bobby Davis</p>
                      </div>
                    </td>
                    <td data-label="Payment type">Bank Transfer</td>
                    <td data-label="Status">
                      <div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          id="SwitchCheck2"
                        />
                      </div>
                    </td>
                    <td data-label="Status Two">
                      <div class="dropdown">
                        <button
                          class="dropdown-toggle i-btn danger btn--md"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          Select Status
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-check"></i>Done</a
                            >
                          </li>
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-clock-history"></i>Pending</a
                            >
                          </li>
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-x"></i>Blocked</a
                            >
                          </li>
                        </ul>
                      </div>
                    </td>
                    <td data-label="Date">Aug 30,2022</td>
                    <td data-label="Expire">Dec 30,2022</td>
                    <td data-label="Priority">
                      <button class="i-badge danger">Hight</button>
                    </td>
                    <td data-label="Action">
                      <div class="table-action">
                        <button
                          type="button"
                          class="icon-btn icon-btn-sm warning"
                          data-bs-toggle="modal"
                          data-bs-target="#exampleModal"
                        >
                          <i class="bi bi-pencil"></i>
                        </button>

                        <div class="dropdown">
                          <button
                            class="dropdown-toggle icon-btn icon-btn-sm info"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                          >
                            <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-trash3"></i>
                                Delete
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-eye"></i>
                                View
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td data-label="Transaction ID">
                      <input class="form-check-input" type="checkbox" />
                    </td>
                    <td data-label="Customer">
                      <div class="user-meta-info">
                        <p>Bobby Davis</p>
                      </div>
                    </td>
                    <td data-label="Payment type">Bank Transfer</td>
                    <td data-label="Status">
                      <div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          id="SwitchCheck10"
                          checked=""
                        />
                      </div>
                    </td>
                    <td data-label="Status Two">
                      <div class="dropdown">
                        <button
                          class="dropdown-toggle i-btn primary btn--md"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          Select Status
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-check"></i>Done</a
                            >
                          </li>
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-clock-history"></i>Pending</a
                            >
                          </li>
                          <li>
                            <a
                              class="dropdown-item text--danger bg--danger-light"
                              href="#"
                              ><i class="bi bi-x"></i>Blocked</a
                            >
                          </li>
                        </ul>
                      </div>
                    </td>
                    <td data-label="Date">Aug 30,2022</td>
                    <td data-label="Expire">Dec 30,2022</td>
                    <td data-label="Priority">
                      <button class="i-badge success">Low</button>
                    </td>
                    <td data-label="Action">
                      <div class="table-action">
                        <button
                          type="button"
                          class="icon-btn icon-btn-sm warning"
                          data-bs-toggle="modal"
                          data-bs-target="#exampleModal"
                        >
                          <i class="bi bi-pencil"></i>
                        </button>

                        <div class="dropdown">
                          <button
                            class="dropdown-toggle icon-btn icon-btn-sm info"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                          >
                            <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-trash3"></i>
                                Delete
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-eye"></i>
                                View
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td data-label="Transaction ID">
                      <input class="form-check-input" type="checkbox" />
                    </td>
                    <td data-label="Customer">
                      <div class="user-meta-info">
                        <p>Bobby Davis</p>
                      </div>
                    </td>
                    <td data-label="Payment type">Bank Transfer</td>
                    <td data-label="Status">
                      <div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          id="SwitchCheck3"
                        />
                      </div>
                    </td>
                    <td data-label="Status Two">
                      <div class="dropdown">
                        <button
                          class="dropdown-toggle i-btn warning btn--md"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          Select Status
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-check"></i>Done</a
                            >
                          </li>
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-clock-history"></i>Pending</a
                            >
                          </li>
                          <li>
                            <a
                              class="dropdown-item text--danger bg--danger-light"
                              href="#"
                              ><i class="bi bi-x"></i>Blocked</a
                            >
                          </li>
                        </ul>
                      </div>
                    </td>
                    <td data-label="Date">Aug 30,2022</td>
                    <td data-label="Expire">Dec 30,2022</td>
                    <td data-label="Priority">
                      <button class="i-badge success">Low</button>
                    </td>
                    <td data-label="Action">
                      <div class="table-action">
                        <button
                          type="button"
                          class="icon-btn icon-btn-sm warning"
                          data-bs-toggle="modal"
                          data-bs-target="#exampleModal"
                        >
                          <i class="bi bi-pencil"></i>
                        </button>

                        <div class="dropdown">
                          <button
                            class="dropdown-toggle icon-btn icon-btn-sm info"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                          >
                            <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-trash3"></i>
                                Delete
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-eye"></i>
                                View
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td data-label="Transaction ID">
                      <input class="form-check-input" type="checkbox" />
                    </td>
                    <td data-label="Customer">
                      <div class="user-meta-info">
                        <p>Bobby Davis</p>
                      </div>
                    </td>
                    <td data-label="Payment type">Bank Transfer</td>
                    <td data-label="Status">
                      <div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          id="SwitchCheck4"
                          checked=""
                        />
                      </div>
                    </td>
                    <td data-label="Status Two">
                      <div class="dropdown">
                        <button
                          class="dropdown-toggle i-btn info btn--md"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          Select Status
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-check"></i>Done</a
                            >
                          </li>
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-clock-history"></i>Pending</a
                            >
                          </li>
                          <li>
                            <a
                              class="dropdown-item text--danger bg--danger-light"
                              href="#"
                              ><i class="bi bi-x"></i>Blocked</a
                            >
                          </li>
                        </ul>
                      </div>
                    </td>
                    <td data-label="Date">Aug 30,2022</td>
                    <td data-label="Expire">Dec 30,2022</td>
                    <td data-label="Priority">
                      <button class="i-badge success">Low</button>
                    </td>
                    <td data-label="Action">
                      <div class="table-action">
                        <button
                          type="button"
                          class="icon-btn icon-btn-sm warning"
                          data-bs-toggle="modal"
                          data-bs-target="#exampleModal"
                        >
                          <i class="bi bi-pencil"></i>
                        </button>

                        <div class="dropdown">
                          <button
                            class="dropdown-toggle icon-btn icon-btn-sm info"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                          >
                            <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-trash3"></i>
                                Delete
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-eye"></i>
                                View
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td data-label="Transaction ID">
                      <input class="form-check-input" type="checkbox" />
                    </td>
                    <td data-label="Customer">
                      <div class="user-meta-info">
                        <p>Bobby Davis</p>
                      </div>
                    </td>
                    <td data-label="Payment type">Bank Transfer</td>
                    <td data-label="Status">
                      <div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          id="SwitchCheck5"
                        />
                      </div>
                    </td>
                    <td data-label="Status Two">
                      <div class="dropdown">
                        <button
                          class="dropdown-toggle i-btn success btn--md"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          Select Status
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-check"></i>Done</a
                            >
                          </li>
                          <li>
                            <a class="dropdown-item" href="#"
                              ><i class="bi bi-clock-history"></i>Pending</a
                            >
                          </li>
                          <li>
                            <a
                              class="dropdown-item text--danger bg--danger-light"
                              href="#"
                              ><i class="bi bi-x"></i>Blocked</a
                            >
                          </li>
                        </ul>
                      </div>
                    </td>
                    <td data-label="Date">Aug 30,2022</td>
                    <td data-label="Expire">Dec 30,2022</td>
                    <td data-label="Priority">
                      <button class="i-badge success">Low</button>
                    </td>
                    <td data-label="Action">
                      <div class="table-action">
                        <button
                          type="button"
                          class="icon-btn icon-btn-sm warning"
                          data-bs-toggle="modal"
                          data-bs-target="#exampleModal"
                        >
                          <i class="bi bi-pencil"></i>
                        </button>

                        <div class="dropdown">
                          <button
                            class="dropdown-toggle icon-btn icon-btn-sm info"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                          >
                            <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-trash3"></i>
                                Delete
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#"
                                ><i class="bi bi-eye"></i>
                                View
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="i-card-md">
          <div class="card-header">
            <h4 class="card-title">Earnings</h4>
          </div>
          <div class="card-body">
            <div id="apexarea-1" class="apex-chart"></div>
          </div>
        </div>
      </div>

      <div class="col-xl-4">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">Report post by type</h4>
          </div>
          <div class="card-body">
            <div id="pieChartOne" class="apex-chart"></div>
          </div>
        </div>
      </div>
    </div>

@endsection
