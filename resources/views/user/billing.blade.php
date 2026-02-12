@extends('layouts.account')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Billing')

@section('content')
  @livewire('user.billing')
@endsection
