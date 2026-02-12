@extends('layouts.account')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Profile')

@section('content')
  @livewire('user.profile')
@endsection
