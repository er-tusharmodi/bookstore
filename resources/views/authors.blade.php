@extends('layouts.site')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Authors')
@section('page', 'authors')

@section('content')
  @livewire('authors-page')
@endsection
