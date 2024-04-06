@extends('layouts.master')
@section('content')

    @php
        $user = auth_user('web');
        $planSection            = get_content("content_plan")->first();
        $subscription           = $user->runningSubscription;
        $currentPlan            = $subscription && $subscription->package ? $subscription->package: null;
    @endphp


    <div class="i-card mb-4">
      <div class="row">
        <div class="col-lg-9">
          <div class="d-flex align-items-center justify-content-start gap-4">
              <div class="avatar-100 profile-picture">
              <div class="file-input">
                <input
                  type="file"
                  name="file-input"
                  id="file-input"
                  class="file-input__input"
                />
                <label class="file-input__label" for="file-input">
                  <span><i class="bi bi-camera-fill"></i></span></label>
              </div>
              <img src="https://i.ibb.co/GC7Q0M2/Ellipse-82.png" class="rounded-50" alt="Ellipse-82">
              </div>
              <div class="text-start">
                <h4>Olivia Clare</h4>
                <p>Joined On 12 Feb 2028 30:25 PM</p>
                <div class="mt-4">
                  <div class="fs-18"><span class="text--dark fw-bold">Email:</span> olivia@gmail.com</div>
                  <div class="fs-18"><span class="text--dark fw-bold">Phone:</span> 0123456789</div>
                </div>
              </div>
          </div>
        </div>
        <div class="col-lg-3">
            <div class="p-4 bg-light radius-16">
                <h4 class="mb-2 fw-normal">Balance</h4>
                <h3>$520.00</h3>
                <div class="d-flex justify-content-start gap-3 mt-3">
                  <a href="#" class="i-btn btn--lg btn--primary capsuled">Update</a>
                  <a href="#" class="i-btn btn--lg btn--primary capsuled">Deposite</a>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div class="i-card">
      <div class="plan-detail">
          <div class="container-fluid px-0">
            <div class="i-card mb-4 border">
              <ul class="nav nav-tabs gap-4 style-2 mb-30" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-one" data-bs-toggle="tab" data-bs-target="#tab-one-pane" type="button" role="tab" aria-controls="tab-one-pane" aria-selected="true">Edit Profile</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-two" data-bs-toggle="tab" data-bs-target="#tab-two-pane" type="button" role="tab" aria-controls="tab-two-pane" aria-selected="false">Password</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-three" data-bs-toggle="tab" data-bs-target="#tab-three-pane" type="button" role="tab" aria-controls="tab-three-pane" aria-selected="false">Affiliate Confiure</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-four" data-bs-toggle="tab" data-bs-target="#tab-four-pane" type="button" role="tab" aria-controls="tab-four-pane" aria-selected="false">Plans</button>
                  </li>
                </ul>
                <p>Pick the plan that works best for you</p>
                <p><span class="fw-bold text--dark">You are still in Solo Plans</span> You are still in solo plan and have decided to go ahead and start using the new plan?</p>
            </div>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="tab-one-pane" role="tabpanel" aria-labelledby="tab-one" tabindex="0">
                <form>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-inner">
                        <label for="name">First Name</label>
                        <input type="text" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-inner">
                        <label for="name">Last Name</label>
                        <input type="text" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Email</label>
                        <input type="email" placeholder="Enter Email">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <label for="name">Phone Number</label>
                      <div class="form-inner select-with-input">
                          <select class="select2">
                            <option value="+880">+880</option>
                            <option value="+0092">+0092</option>
                            <option value="+0091">+0091</option>
                            <option value="+005">+005</option>
                          </select>
                          <input type="email" placeholder="92000000">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <button class="i-btn btn--lg btn--primary capsuled" type="submit">Update <span><i class="bi bi-arrow-up-right"></i></span></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="tab-two-pane" role="tabpanel" aria-labelledby="tab-two" tabindex="0">
              <form>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Old Password</label>
                        <input type="text" placeholder="Old Password">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">New Password</label>
                        <input type="text" placeholder="New Password">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Confirm Password</label>
                        <input type="email" placeholder="Confirm Password">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <button class="i-btn btn--lg btn--primary capsuled" type="submit">Update <span><i class="bi bi-arrow-up-right"></i></span></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="tab-three-pane" role="tabpanel" aria-labelledby="tab-three" tabindex="0">
                <form>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Referral Code</label>
                        <input type="text" placeholder="Referral Code">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Referral URL</label>
                        <input type="text" placeholder="Enter Value">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <button class="i-btn btn--lg btn--primary capsuled" type="submit">Update <span><i class="bi bi-arrow-up-right"></i></span></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="tab-four-pane" role="tabpanel" aria-labelledby="tab-four" tabindex="0">
                <div class="plan-detail-wrapper">
                  <div class="row gy-4 gx-4">
                    <div class="col-xl-4 col-md-6">
                      <div class="plan-detail-card">
                        <div class="plan-detail-top">
                          <p class="mb-0">For Mini Business</p>
                          <span>title</span>
                          <p>description</p>

                          <div class="price">
                            <h4>
                              $66
                              <span>$55</span>
                            </h4>
                          </div>
                        </div>
                        <div class="plan-detail-body">
                          <h5 class="mb-4">What’s included</h5>
                          <ul class="mb-0">
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social profile</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Pre-built ai template</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Facebook platform access</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Schedule post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Gpt-3.5-turbo Open ai model</p>
                            </li> 
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>20 Word token</p>
                            </li> 
                          </ul>
                        </div>
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                      <div class="plan-detail-card">
                        <div class="plan-detail-top">
                          <p class="mb-0">For Mini Business</p>
                          <span>title</span>
                          <p>description</p>

                          <div class="price">
                            <h4>
                              $66
                              <span>$55</span>
                            </h4>
                          </div>
                        </div>
                        <div class="plan-detail-body">
                          <h5 class="mb-4">What’s included</h5>
                          <ul class="mb-0">
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social profile</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Pre-built ai template</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Facebook platform access</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Schedule post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Gpt-3.5-turbo Open ai model</p>
                            </li> 
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>20 Word token</p>
                            </li> 
                          </ul>
                        </div>
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                      <div class="plan-detail-card">
                        <div class="plan-detail-top">
                          <p class="mb-0">For Mini Business</p>
                          <span>title</span>
                          <p>description</p>

                          <div class="price">
                            <h4>
                              $66
                              <span>$55</span>
                            </h4>
                          </div>
                        </div>
                        <div class="plan-detail-body">
                          <h5 class="mb-4">What’s included</h5>
                          <ul class="mb-0">
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social profile</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Pre-built ai template</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Facebook platform access</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Schedule post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Gpt-3.5-turbo Open ai model</p>
                            </li> 
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>20 Word token</p>
                            </li> 
                          </ul>
                        </div>
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>

@endsection




