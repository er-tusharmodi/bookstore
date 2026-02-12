@extends('layouts.site')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Store')
@section('page', 'store')

@section('content')
  @livewire('store-page')
@endsection
