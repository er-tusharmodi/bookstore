@extends('layouts.site')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Book Detail')
@section('page', 'book-detail')

@section('content')
  @livewire('book-detail-page', ['slug' => $slug])
@endsection
