@extends('layouts.app')

@section('content')
    <device-product-component></device-product-component>
@endsection

@section('script')
    <script src="{{ asset('/js/devices/product.js') }}"></script>
@endsection