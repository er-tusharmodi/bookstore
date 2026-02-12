@extends('layouts.site')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Author Detail')
@section('page', 'author-detail')

@section('content')
  @livewire('author-detail-page', ['slug' => $slug])
@endsection
