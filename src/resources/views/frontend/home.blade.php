@extends('layouts.master')
@section('content')

@php
   $bannerContent = get_content("content_banner");  

   @dd( $bannerContent);
@endphp






@endsection