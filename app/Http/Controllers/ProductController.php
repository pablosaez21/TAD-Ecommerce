<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('name')->get();
        $products = Product::with('categories')->latest()->paginate(12);

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        $product->load('categories');

        return view('products.show', compact('product'));
    }

    public function create(): View
    {
        $this->ensureAdmin();

        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:2048'],
            'stock' => ['required', 'integer', 'min:0'],
            'active' => ['required', 'boolean'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        $product = Product::create($validated);
        $product->categories()->sync($validated['categories'] ?? []);

        return redirect()
            ->route('products.show', $product)
            ->with('status', 'Producto creado correctamente.');
    }

    public function edit(Product $product): View
    {
        $this->ensureAdmin();

        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:2048'],
            'stock' => ['required', 'integer', 'min:0'],
            'active' => ['required', 'boolean'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        $product->update($validated);
        $product->categories()->sync($validated['categories'] ?? []);

        return redirect()
            ->route('products.show', $product)
            ->with('status', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->ensureAdmin();

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', 'Producto eliminado correctamente.');
    }

    protected function ensureAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }
}
