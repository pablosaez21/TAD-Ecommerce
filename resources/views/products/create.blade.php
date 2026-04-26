@extends('layouts.layout')

@section('content')
<h2 class="mb-3">Nuevo producto</h2>
<form action="{{ route('products.store') }}" method="POST" class="card card-body">
    @csrf
    @include('products.partials.form', ['product' => null])
    <button class="btn btn-primary mt-3" type="submit">Guardar</button>
</form>
@endsection
