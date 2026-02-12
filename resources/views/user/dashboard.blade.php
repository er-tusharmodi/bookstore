@extends('layouts.account')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | User Dashboard')

@section('content')
  @livewire('user.dashboard')
@endsection
