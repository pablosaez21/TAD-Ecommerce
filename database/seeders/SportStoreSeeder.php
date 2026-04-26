<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SportStoreSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Running', 'description' => 'Ropa y accesorios para correr.'],
            ['name' => 'Fitness', 'description' => 'Productos para entrenamiento funcional y gimnasio.'],
            ['name' => 'Tennis', 'description' => 'Equipamiento y ropa para tenis.'],
        ])->map(fn (array $category) => Category::query()->updateOrCreate(
            ['slug' => Str::slug($category['name'])],
            [
                'name' => $category['name'],
                'description' => $category['description'],
            ]
        ));

        $products = [
            [
                'name' => 'Camiseta Dry-Fit Runner',
                'description' => 'Camiseta ligera y transpirable para running.',
                'price' => 29.90,
                'stock' => 120,
                'active' => true,
                'image' => 'products/running-shirt.jpg',
                'categories' => ['running'],
            ],
            [
                'name' => 'Leggings Pro Fitness',
                'description' => 'Leggings elasticos de compresion para entrenamientos intensos.',
                'price' => 44.50,
                'stock' => 80,
                'active' => true,
                'image' => 'products/fitness-leggings.jpg',
                'categories' => ['fitness'],
            ],
            [
                'name' => 'Polo Performance Tennis',
                'description' => 'Polo tecnico con secado rapido para cancha.',
                'price' => 39.00,
                'stock' => 60,
                'active' => true,
                'image' => 'products/tennis-polo.jpg',
                'categories' => ['tennis'],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::query()->updateOrCreate(
                ['name' => $data['name']],
                [
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'active' => $data['active'],
                    'image' => $data['image'],
                ]
            );

            $categoryIds = $categories
                ->whereIn('slug', $data['categories'])
                ->pluck('id')
                ->all();

            $product->categories()->sync($categoryIds);
        }

        User::query()->updateOrCreate(
            ['email' => 'admin@sportstore.com'],
            [
                'name' => 'Administrador SportStore',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'language' => 'es',
            ]
        );
    }
}
