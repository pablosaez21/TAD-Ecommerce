<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input class="form-control" name="name" value="{{ old('name', $product?->name) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Precio</label>
        <input class="form-control" type="number" step="0.01" min="0" name="price" value="{{ old('price', $product?->price) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Stock</label>
        <input class="form-control" type="number" min="0" name="stock" value="{{ old('stock', $product?->stock ?? 0) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">Descripcion</label>
        <textarea class="form-control" name="description">{{ old('description', $product?->description) }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Imagen (URL o ruta)</label>
        <input class="form-control" name="image" value="{{ old('image', $product?->image) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Activo</label>
        <select class="form-select" name="active" required>
            <option value="1" @selected(old('active', $product?->active ?? 1) == 1)>Si</option>
            <option value="0" @selected(old('active', $product?->active ?? 1) == 0)>No</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Categorias</label>
        @php
            $selected = old('categories', $product?->categories?->pluck('id')->all() ?? []);
        @endphp
        <select name="categories[]" class="form-select" multiple>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(in_array($category->id, $selected))>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>
