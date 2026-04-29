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
    public function run(): void
    {
        // ── Categorías ───────────────────────────────────────────
        $categories = collect([
            ['name' => 'Running',   'description' => 'Ropa y accesorios para correr.'],
            ['name' => 'Fitness',   'description' => 'Productos para entrenamiento funcional y gimnasio.'],
            ['name' => 'Tennis',    'description' => 'Equipamiento y ropa para tenis.'],
            ['name' => 'Lifestyle', 'description' => 'Ropa deportiva para el día a día.'],
        ])->map(fn (array $cat) => Category::query()->updateOrCreate(
            ['slug' => Str::slug($cat['name'])],
            ['name' => $cat['name'], 'description' => $cat['description']]
        ));

        // ── Productos ────────────────────────────────────────────
        $products = [
            [
                'name'        => 'Producto de prueba',
                'description' => 'Producto de prueba para verificar el flujo de compra.',
                'price'       => 1.00,
                'stock'       => 99,
                'active'      => true,
                'image'       => null,
                'categories'  => ['running'],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::query()->updateOrCreate(
                ['name' => $data['name']],
                [
                    'description' => $data['description'],
                    'price'       => $data['price'],
                    'stock'       => $data['stock'],
                    'active'      => $data['active'],
                    'image'       => $data['image'],
                ]
            );

            $categoryIds = $categories
                ->whereIn('slug', $data['categories'])
                ->pluck('id')
                ->all();

            $product->categories()->sync($categoryIds);
        }

        // ── Usuarios ─────────────────────────────────────────────
        User::query()->updateOrCreate(
            ['email' => 'admin@doublehelix.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'language' => 'es',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'usuario@doublehelix.com'],
            [
                'name'     => 'Usuario de prueba',
                'password' => Hash::make('password'),
                'role'     => 'user',
                'language' => 'es',
            ]
        );
    }
}
