@extends('layouts.master')
@section('content')

@php
$user = auth_user('web');
$planSection = get_content("content_plan")->first();
$subscription = $user->runningSubscription;
$currentPlan = $subscription && $subscription->package ? $subscription->package: null;
@endphp

<div class="current-plan-card mb-4">
    <h4 class="card--title mb-4">Current Plan</h4>
    <div class="row align-items-center gy-5">
        <div class="col-lg-5">
            <div class="row g-3">
                <div class="col-12">
                    <div class="bg--linear-primary text-center">
                        <div class="card-body p-3">
                            <h6 class="text-white opacity-75 fw-normal fs-13">
                                Total Deposit Amount
                            </h6>
                            <h3 class="fw-bold mt-1 mb-3 text-white fs-19">Title</h3>
                            <p class="text-white opacity-75">The Total Deposit Amount Accumulated From All Users
                                Within The System.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="current-info-single">
                        <p>word left</p>
                        <h5>455</h5>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="current-info-single">
                        <p>Characters</p>
                        <h5>3453458</h5>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="current-info-single">
                        <p>word left</p>
                        <h5>455</h5>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="current-info-single">
                        <p>Remaining Minutes</p>
                        <h5>75</h5>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="current-info-single">
                        <p>word left</p>
                        <h5>455</h5>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="current-info-single">
                        <p>Characters</p>
                        <h5>3453458</h5>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="current-info-single">
                        <p>word left</p>
                        <h5>455</h5>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="current-info-single">
                        <p>Remaining Minutes</p>
                        <h5>75</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 ps-lg-5">
            <div class="plan-upgrade">
                <h4 class="mb-4 title"><span><img src="https://i.ibb.co/rbjn4Cr/forward.png" class="me-1"
                            alt="forward"></span> Upgrade Your Plan</h4>
                <div class="avatar-120 mb-3 mx-auto">
                    <img src="https://i.ibb.co/FBv78WT/upgrade.png" alt="upgrade">
                </div>
                <p class="mb-4">Updating your plan is a crucial step in ensuring that your goals and strategies
                    remain relevant and effective in a dynamic environment. As circumstances change, whether due to
                    shifts in the market, new technological advancements, or evolving personal or organizational
                    priorities</p>
                <a href="#" class="i-btn btn--primary-outline btn--lg capsuled text-uppercase mx-auto">Update Plan<i
                        class="bi bi-arrow-up-circle"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="i-card-md">
    <div class="card-body">
        <div class="mb-5 d-flex justify-content-center">
            <div class="nav plan-tab" role="tablist">
                <button class="nav-link active" id="MONTHLY-tab" data-bs-toggle="pill" data-bs-target="#MONTHLY"
                    type="button" role="tab" aria-controls="MONTHLY" aria-selected="true">
                    Monthly
                </button>
                <button class="nav-link" id="YEARLY-tab" data-bs-toggle="pill" data-bs-target="#YEARLY" type="button"
                    role="tab" aria-controls="YEARLY" aria-selected="false" tabindex="-1">
                    Yearly
                </button>
                <button class="nav-link" id="UNLIMITED-tab" data-bs-toggle="pill" data-bs-target="#UNLIMITED"
                    type="button" role="tab" aria-controls="UNLIMITED" aria-selected="false" tabindex="-1">
                    Unlimited
                </button>
            </div>
        </div>


        <div class="select-input-wrapper d-flex align-items-center justify-content-between">
            <select name="cat" class="select2">
                <option value="1">one</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <input class="flex-grow-1" type="text" placeholder="search">
            <button type="submit">Search</button>
        </div>

        <div class="tab-content" id="tab-plans">
            <div class="tab-pane fade active show" id="MONTHLY" role="tabpanel" aria-labelledby="MONTHLY-tab"
                tabindex="0">
                <div class="row gy-4 gx-4">
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card style-recomend">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
                            <div class="recomend">
                                <span>Recommended</span>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="YEARLY" role="tabpanel" aria-labelledby="YEARLY-tab" tabindex="0">
                <div class="row gy-4 gx-4">
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card style-recomend">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
                            <div class="recomend">
                                <span>Recommended</span>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="UNLIMITED" role="tabpanel" aria-labelledby="UNLIMITED-tab" tabindex="0">
                <div class="row gy-4 gx-4">
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card style-recomend">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
                            <div class="recomend">
                                <span>Recommended</span>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="plan-detail-card">
                            <div class="icon">
                                <i class="bi bi-gem"></i>
                            </div>
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
                                <ul>
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
                            <a href="#"
                                class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Affiliate section -->
<div class="current-plan-card mt-4">
    <h4 class="card--title mb-4">Current Plan</h4>
    <div class="row align-items-center gy-5">
        <div class="col-lg-4">
            <div class="row g-3">
                <div class="col-12">
                    <div class="bg--linear-primary text-center mb-3">
                        <div class="card-body p-3">
                            <h3 class="fw-bold mt-1 mb-3 text-white fs-20">Affiliate Program</h3>
                            <p class="text-white opacity-75">Referral Commission Rate: <b>70%</b></p>
                        </div>
                    </div>
                    <ul class="subcription-list">
                        <li><span> This Earning </span><span> $4545654 </span></li>
                        <li><span> Total Reffered </span><span>343</span></li>
                    </ul>
                    <form class="referral-form mt-5">
                        <div class="form-inner">
                            <div class="input-with-btn">
                                <input type="text" value="http://localhost/EngageHub/user/plans">
                                <button><i class="bi bi-clipboard"></i></button>
                            </div>
                        </div>

                        <div class="form-inner">
                            <label class="mb-1" for="">Invite your Friend</label>
                            <div class="input-with-btn">
                                <input type="text" placeholder="Enter Email">
                                <button><i class="bi bi-send"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 ps-lg-5">
            <div class="plan-upgrade">
                <h4 class="mb-4 title">How It Works</h4>
                <div class="row g-4">
                    <div class="col-xxl-4 col-lg-6">
                        <div class="how-single">
                            <div class="serail-no">01</div>
                            <div class="icon">
                                <i class="bi bi-envelope-paper"></i>
                            </div>
                            <div class="content">
                                <h6>Forward Invitation</h6>
                                <p>Send your referral link to your friends and tell them how cool it is!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-lg-6">
                        <div class="how-single">
                            <div class="serail-no">02</div>
                            <div class="icon">
                                <i class="bi bi-envelope-paper"></i>
                            </div>
                            <div class="content">
                                <h6>Register</h6>
                                <p>Invite your friends to register using the referral link you've shared.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-lg-6">
                        <div class="how-single">
                            <div class="serail-no">03</div>
                            <div class="icon">
                                <i class="bi bi-envelope-paper"></i>
                            </div>
                            <div class="content">
                                <h6>Generate Commissions</h6>
                                <p>Get commission for all the payments they make on their subscription plans.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="i-card-md mt-4">
    <div class="card-header">
        <h4 class="card--title">Two-factor Authentication</h4>
    </div>
    <div class="card-body">
        <div class="row gy-5">
            <div class="col-lg-6">
                <div class="authentic-wrap">
                    <div class="content">
                        <h5>Scan QR code using your phone with authentic application following :</h5>
                        <div class="d-flex justify-content-between">
                            <ul>
                                <li>Google Authenticator</li>
                                <li>Microsoft Authenticator</li>
                                <li>Duo Mobile</li>
                            </ul>
                            <div class="qr-image">
                                <img src="https://i.ibb.co/k0kYPg3/Mask-group.jpg" alt="Mask-group">
                            </div>
                        </div>

                        <h5>Or Copy link below and paste in your App</h5>
                        <div class="input-with-btn">
                            <input type="text" class="fw-bold" value="XLXJD98745HNDF990HGH">
                            <button><i class="bi bi-clipboard"></i></button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="authentic-wrap plan-upgrade">
                    <div class="content text-start">
                        <h5>Enter the 6 digit code that is provided in Application :</h5>
                        <form class="enter-digit-form">
                            <div class="input-group-wrapper">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                            </div>
                        </form>
                        <div class="d-flex justify-content-start gap-3 align-items-center mt-5">
                            <button class="i-btn btn--lg btn--primary-outline capsuled">Cancel</button>
                            <button type="submit" class="i-btn btn--lg btn--primary capsuled">Verify</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- <div class="i-card mb-4">
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
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
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
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
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
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto w-100">Subscribe</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div> -->

@endsection