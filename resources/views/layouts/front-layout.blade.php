@extends('app')
@section('title', 'Front')
@section('content')
    @livewire('dynamic-sidebar', ['data' => ['ini' => 'ini']])
    @yield('body')
@endsection
