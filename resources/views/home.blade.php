@extends('layouts.layout')

@section('content')
<div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
    <div class="container-fluid py-4">
        <h1 class="display-5 fw-bold text-primary">{{ __('home.title') }}</h1>
        <p class="col-md-8 fs-5">{{ __('home.subtitle') }}</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">{{ __('home.cta_products') }}</a>
    </div>
</div>
@endsection
