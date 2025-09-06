@extends('home.body.home_master')

@section('home')

{{-- Hero Section --}}
@include('home.homelayout.slider')

{{-- Outdoor Activities Section --}}
@include('home.homelayout.features')

{{-- About Section --}}
@include('home.homelayout.clarifies')

{{-- Itineraries Section --}}
@include('home.homelayout.itineraries')

{{-- Sorties/Expéditions Section --}}
@include('home.homelayout.sorties')

{{-- Blog Articles Section --}}
@include('home.homelayout.blog_articles')

@endsection