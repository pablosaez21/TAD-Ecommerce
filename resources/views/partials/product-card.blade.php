<div class="dh-product-card h-100">

    {{-- Imagen formato editorial 3:4 --}}
    <div class="dh-product-img">

        @if ($product->image ?? false)
            <img src="{{ asset('storage/' . $product->image) }}"
                 alt="{{ $product->name }}">
        @else
            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-image" style="font-size: 3rem; color: #D1D5DB;"></i>
            </div>
        @endif

        @if (($product->stock ?? 1) === 0)
            <span class="position-absolute top-0 start-0 m-2"
                  style="background: var(--dh-muted); color: #fff; font-size: 0.68rem; letter-spacing: 1px; text-transform: uppercase; padding: 3px 8px; border-radius: 2px; font-family: 'DM Sans', sans-serif;">
                Agotado
            </span>
        @endif

    </div>

    {{-- Info --}}
    <div style="padding: 14px 0 8px;">
        <p class="dh-product-name mb-1">{{ $product->name }}</p>
        <p class="dh-product-price mb-0">{{ number_format($product->price, 2) }} €</p>
    </div>

    {{-- Acciones --}}
    <div class="d-flex gap-2 pb-3">
        <a href="{{ route('products.show', $product) }}"
           class="btn btn-dh-outline btn-sm flex-grow-1" style="font-size: 0.8rem; padding: 7px 12px;">
            Ver producto
        </a>

        @if (($product->stock ?? 1) > 0)
            <form method="POST" action="{{ route('cart.add', $product) }}" class="flex-grow-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-dh btn-sm w-100" style="font-size: 0.8rem; padding: 7px 12px;">
                    <i class="bi bi-bag-plus me-1"></i>Añadir
                </button>
            </form>
        @else
            <button class="btn btn-sm flex-grow-1" disabled
                    style="background: #E5E7EB; color: var(--dh-muted); border-radius: 2px; border: none; font-size: 0.8rem;">
                Agotado
            </button>
        @endif
    </div>

</div>
