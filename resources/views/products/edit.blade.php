@extends('layouts.layout')

@section('content')
<h2 class="mb-3">Editar producto</h2>
<form action="{{ route('products.update', $product) }}" method="POST" class="card card-body">
    @csrf
    @method('PUT')
    @include('products.partials.form', ['product' => $product])
    <button class="btn btn-primary mt-3" type="submit">Actualizar</button>
</form>
@endsection
