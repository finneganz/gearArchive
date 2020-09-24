@extends('layouts.app')

@section('content')
    <device-add-component
        :is-logged-in = "{{ $isLoggedIn }}"
        :errors="{{ $errors }}"
    ></device-add-component>
@endsection

@section('script')
    <script src="{{ asset('/js/devices/add.js') }}"></script>
@endsection