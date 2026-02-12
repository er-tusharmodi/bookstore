@extends('layouts.account')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Order List')

@section('content')
  @livewire('user.order-list')
@endsection
