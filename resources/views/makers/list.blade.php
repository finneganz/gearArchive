@extends('layouts.app')

@section('content')
    <makers-component
        :auth = "{{ $auth }}"
        :makers = "{{ $makers }}"
    ></makers-component>
@endsection

@section('script')
    <script src="{{ asset('/js/makers/makers.js') }}"></script>
@endsection