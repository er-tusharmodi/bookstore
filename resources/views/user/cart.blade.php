@extends('layouts.account')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Cart')

@section('content')
  @livewire('user.cart')
@endsection
