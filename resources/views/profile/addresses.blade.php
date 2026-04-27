@extends('layouts.app')

@section('content')
<h2 class="mb-3">Mis direcciones</h2>

<div class="card card-body mb-4">
    <h5>Nueva direccion</h5>
    <form method="POST" action="{{ route('profile.addresses.store') }}" class="row g-2">
        @csrf
        <div class="col-md-6"><input class="form-control" name="street" placeholder="Calle" required></div>
        <div class="col-md-3"><input class="form-control" name="city" placeholder="Ciudad" required></div>
        <div class="col-md-3"><input class="form-control" name="province" placeholder="Provincia" required></div>
        <div class="col-md-3"><input class="form-control" name="postal_code" placeholder="Codigo postal" required></div>
        <div class="col-md-3"><input class="form-control" name="country" placeholder="Pais" required></div>
        <div class="col-md-3"><input class="form-control" name="phone" placeholder="Telefono" required></div>
        <div class="col-md-3 d-flex align-items-center">
            <label><input type="checkbox" name="is_default" value="1"> Predeterminada</label>
        </div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Guardar</button></div>
    </form>
</div>

@foreach($addresses as $address)
    <div class="card card-body mb-3">
        <p class="mb-2">{{ $address->street }}, {{ $address->city }}, {{ $address->province }} - {{ $address->postal_code }} ({{ $address->country }})</p>
        <p class="mb-2">Tel: {{ $address->phone }} @if($address->is_default)<span class="badge text-bg-primary">Predeterminada</span>@endif</p>

        <form method="POST" action="{{ route('profile.addresses.update', $address->id) }}" class="row g-2 mb-3">
            @csrf
            @method('PUT')
            <div class="col-md-6"><input class="form-control" name="street" value="{{ $address->street }}" required></div>
            <div class="col-md-3"><input class="form-control" name="city" value="{{ $address->city }}" required></div>
            <div class="col-md-3"><input class="form-control" name="province" value="{{ $address->province }}" required></div>
            <div class="col-md-3"><input class="form-control" name="postal_code" value="{{ $address->postal_code }}" required></div>
            <div class="col-md-3"><input class="form-control" name="country" value="{{ $address->country }}" required></div>
            <div class="col-md-3"><input class="form-control" name="phone" value="{{ $address->phone }}" required></div>
            <div class="col-md-3 d-flex align-items-center">
                <label><input type="checkbox" name="is_default" value="1" @checked($address->is_default)> Predeterminada</label>
            </div>
            <div class="col-12">
                <button class="btn btn-sm btn-primary" type="submit">Actualizar direccion</button>
            </div>
        </form>

        <div class="d-flex gap-2">
            <form method="POST" action="{{ route('profile.addresses.destroy', $address->id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
            </form>
        </div>
    </div>
@endforeach

<div class="card card-body mt-4">
    <h5>Cambiar idioma</h5>
    <form action="{{ route('profile.language.update') }}" method="POST" class="d-flex gap-2">
        @csrf
        <select class="form-select" name="language" style="max-width: 200px;">
            <option value="es" @selected(app()->getLocale() === 'es')>Espanol</option>
            <option value="en" @selected(app()->getLocale() === 'en')>English</option>
        </select>
        <button class="btn btn-primary" type="submit">Actualizar</button>
    </form>
</div>
@endsection
