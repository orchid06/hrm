@extends('layouts.master')
@section('content')

@php
   $bannerContent  = get_content("content_banner")->first();
   $bannerElements = get_content("element_banner");
   $bannerImg      = $bannerContent->file->where("type",'image')->first();
@endphp

  @include('frontend.sections.banner')
  @include('frontend.sections.about')

@include('frontend.partials.page_section')
@endsection
