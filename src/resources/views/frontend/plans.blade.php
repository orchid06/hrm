@extends('layouts.master')
@section('content')

@php

$planSection = get_content("content_plan")->first();
@endphp


<section class="inner-banner">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-8 mx-auto">
                <div class="inner-banner-content text-center">
                    <h2>{{@$planSection->value->title}}</h2>
                    <p>
                        {{@$planSection->value->description}}
                    </p>

                    <div class="mb-5 d-flex justify-content-center">
                        <div class="nav plan-tab" role="tablist">
                            @foreach (App\Enums\PlanDuration::toArray() as $key => $value)
                            <button class="nav-link {{$loop->index  == 0 ? 'active' :''}}" id="{{$key}}-tab"
                                data-bs-toggle="pill" data-bs-target="#{{$key}}" type="button" role="tab"
                                aria-controls="{{$key}}" aria-selected="true">
                                {{
                                ucfirst(strtolower($key))
                            }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="primary-shade"></div>
    <div class="banner-texture"></div>
</section>

<section class="plan-detail pb-110">
    <div class="container">
        <div class="tab-content" id="tab-plans">
            @foreach (App\Enums\PlanDuration::toArray() as $key => $value)
            <div class="tab-pane fade  {{$loop->index == 0 ? 'show active' : ''}}" id="{{$key}}" role="tabpanel"
                aria-labelledby="{{$key}}-tab" tabindex="0">

                <div class="plan-detail-wrapper">
                    <div class="row gy-4 gx-4">
                        <div class="col-xl-4 col-md-6">
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
                                    class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
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
                                    class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
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
                                    class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@include('frontend.partials.page_section')
@endsection