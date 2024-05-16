@extends('app')
@section('title', 'Dashboard')
@section('content')
    @livewire('dynamic-sidebar', ['data' => ['ini' => 'ini']])
    @yield('body')
@endsection
