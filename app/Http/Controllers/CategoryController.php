<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        $categories = Category::orderBy('name')->get();

        $products = $category->products()
            ->where('active', true)
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'categories', 'products'));
    }
}
