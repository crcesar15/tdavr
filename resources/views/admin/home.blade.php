@extends('layout')
@section('nav_bar')
    @include('partials.admin_nav_var', $user = session()->get('user'))
@endsection
