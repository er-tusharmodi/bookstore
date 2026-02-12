@extends('layouts.site')

@section('title', 'Page')
@section('page', 'page')

@section('content')
  @livewire('page-show', ['slug' => $slug])
@endsection
