@extends('layouts.site')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Home')
@section('page', 'home')

@section('content')
  @livewire('home-page')
@endsection
