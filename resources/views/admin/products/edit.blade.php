@extends('layouts.app')

@section('title', 'Editar — ' . $product->name . ' — Admin')

@section('content')

<section style="padding: 60px 0 120px; background: #F7F7F7;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="mb-5">
                    <a href="{{ route('products.show', $product) }}" style="font-size: 0.82rem; color: var(--dh-muted); text-decoration: none;">
                        ← Volver al producto
                    </a>
                    <p class="mt-3 mb-1" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Administración</p>
                    <h1 style="font-weight: 300; font-size: 2.2rem; color: var(--dh-text); margin-bottom: 0;">Editar producto</h1>
                </div>

                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="background: #fff; padding: 40px; margin-bottom: 24px;">
                        <h5 class="mb-4" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                            Información básica
                        </h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" style="font-size: 0.82rem; color: var(--dh-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                                    Nombre *
                                </label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       style="border-radius: 2px; border: 1px solid #E5E7EB; font-size: 0.9rem;"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size: 0.82rem; color: var(--dh-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                                    Descripción
                                </label>
                                <textarea name="description" rows="4"
                                          class="form-control @error('description') is-invalid @enderror"
                                          style="border-radius: 2px; border: 1px solid #E5E7EB; font-size: 0.9rem; resize: vertical;">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 0.82rem; color: var(--dh-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                                    Precio (€) *
                                </label>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                       step="0.01" min="0"
                                       class="form-control @error('price') is-invalid @enderror"
                                       style="border-radius: 2px; border: 1px solid #E5E7EB; font-size: 0.9rem;"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 0.82rem; color: var(--dh-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                                    Stock *
                                </label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                       min="0"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       style="border-radius: 2px; border: 1px solid #E5E7EB; font-size: 0.9rem;"
                                       required>
                                @error('stock')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 0.82rem; color: var(--dh-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                                    Estado *
                                </label>
                                <select name="active"
                                        class="form-select @error('active') is-invalid @enderror"
                                        style="border-radius: 2px; border: 1px solid #E5E7EB; font-size: 0.9rem;"
                                        required>
                                    <option value="1" @selected(old('active', $product->active) == 1)>Activo</option>
                                    <option value="0" @selected(old('active', $product->active) == 0)>Inactivo</option>
                                </select>
                                @error('active')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size: 0.82rem; color: var(--dh-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                                    Imagen (ruta o URL)
                                </label>
                                @if ($product->image ?? false)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="" style="height: 60px; width: 60px; object-fit: cover;">
                                        <span style="font-size: 0.78rem; color: var(--dh-muted); margin-left: 8px;">Imagen actual</span>
                                    </div>
                                @endif
                                <input type="text" name="image" value="{{ old('image', $product->image) }}"
                                       class="form-control @error('image') is-invalid @enderror"
                                       style="border-radius: 2px; border: 1px solid #E5E7EB; font-size: 0.9rem;"
                                       placeholder="products/ejemplo.jpg">
                                @error('image')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div style="background: #fff; padding: 40px; margin-bottom: 24px;">
                        <h5 class="mb-4" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                            Categorías
                        </h5>
                        @php
                            $selectedCats = old('categories', $product->categories->pluck('id')->all());
                        @endphp
                        @forelse ($categories ?? [] as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox"
                                       name="categories[]" id="cat_{{ $category->id }}"
                                       value="{{ $category->id }}"
                                       @checked(in_array($category->id, $selectedCats))>
                                <label class="form-check-label" for="cat_{{ $category->id }}"
                                       style="font-size: 0.88rem; color: var(--dh-text);">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @empty
                            <p style="font-size: 0.85rem; color: var(--dh-muted);">No hay categorías disponibles.</p>
                        @endforelse
                    </div>

                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-dh-outline" style="padding: 12px 32px; font-size: 0.9rem;">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-dh" style="padding: 12px 40px; font-size: 0.9rem;">
                            Guardar cambios
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

@endsection
