@extends('home.body.home_master')

@section('home')

{{-- Hero Section --}}
@include('home.homelayout.slider')

{{-- Section Dernier Article --}}
@include('home.homelayout.latest-article')

{{-- Section Dernière Sortie --}}
@include('home.homelayout.latest-sortie')

{{-- Main 3 Blocks Section --}}
@include('home.homelayout.main-blocks')

@endsection