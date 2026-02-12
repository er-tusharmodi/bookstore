@extends('layouts.account')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Wishlist')

@section('content')
  @livewire('user.wishlist')
@endsection
