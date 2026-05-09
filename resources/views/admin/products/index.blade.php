@extends('layouts.app')

@section('title', 'Gestión de productos — Admin')

@section('content')

<section style="padding: 60px 0 120px; background: #F7F7F7; min-height: 80vh;">
    <div class="container">

        <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-5">
            <div>
                <p class="mb-1" style="text-transform: uppercase; letter-spacing: 3px; font-size: 0.75rem; color: var(--dh-primary);">Administración</p>
                <h1 style="font-weight: 300; font-size: 2.2rem; color: var(--dh-text); margin-bottom: 0;">Productos</h1>
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-dh" style="padding: 10px 28px; font-size: 0.88rem;">
                <i class="bi bi-plus-lg me-1"></i>Nuevo producto
            </a>
        </div>

        @forelse ($products as $product)
            @if ($loop->first)
                <div style="background: #fff;">
                    <table class="table mb-0" style="font-size: 0.88rem;">
                        <thead>
                            <tr style="border-bottom: 2px solid #F0F0F0;">
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none; width: 48px;"></th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Producto</th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Precio</th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Stock</th>
                                <th style="padding: 14px 24px; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-muted); border: none;">Estado</th>
                                <th style="padding: 14px 24px; border: none;"></th>
                            </tr>
                        </thead>
                        <tbody>
            @endif

                            <tr style="border-bottom: 1px solid #F7F7F7;">
                                <td style="padding: 16px 24px; border: none;">
                                    <div style="width: 40px; height: 40px; background: #F7F7F7; overflow: hidden; flex-shrink: 0;">
                                        @if ($product->image ?? false)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    </div>
                                </td>
                                <td style="padding: 16px 24px; border: none;">
                                    <p class="mb-0 fw-semibold" style="color: var(--dh-text);">{{ $product->name }}</p>
                                    <p class="mb-0" style="font-size: 0.78rem; color: var(--dh-muted);">
                                        {{ Str::limit($product->description ?? '', 60) }}
                                    </p>
                                </td>
                                <td style="padding: 16px 24px; border: none; font-weight: 700; color: var(--dh-primary);">
                                    {{ number_format((float) $product->price, 2) }} €
                                </td>
                                <td style="padding: 16px 24px; border: none; color: var(--dh-text);">
                                    {{ $product->stock }}
                                </td>
                                <td style="padding: 16px 24px; border: none;">
                                    @if ($product->active)
                                        <span style="padding: 3px 10px; border-radius: 2px; font-size: 0.72rem; font-weight: 600; background: #D1FAE5; color: #065F46;">Activo</span>
                                    @else
                                        <span style="padding: 3px 10px; border-radius: 2px; font-size: 0.72rem; font-weight: 600; background: #F3F4F6; color: #374151;">Inactivo</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 24px; border: none; text-align: right; white-space: nowrap;">
                                    <a href="{{ route('products.edit', $product) }}"
                                       style="font-size: 0.82rem; color: var(--dh-primary); text-decoration: none; margin-right: 16px;">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background: none; border: none; font-size: 0.82rem; color: #dc2626; cursor: pointer; padding: 0;"
                                                onclick="return confirm('¿Eliminar {{ addslashes($product->name) }}?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>

            @if ($loop->last)
                        </tbody>
                    </table>
                </div>
            @endif

        @empty
            <div class="text-center" style="background: #fff; padding: 80px 0;">
                <i class="bi bi-box-seam d-block mb-4" style="font-size: 3rem; color: #D1D5DB;"></i>
                <h4 style="font-weight: 300; color: var(--dh-text);">No hay productos</h4>
                <a href="{{ route('products.create') }}" class="btn btn-dh mt-3" style="padding: 10px 28px;">
                    Crear el primero
                </a>
            </div>
        @endforelse

        @if (isset($products) && $products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
