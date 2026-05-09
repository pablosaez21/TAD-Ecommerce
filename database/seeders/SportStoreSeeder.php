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
            ['name' => 'Lifestyle', 'description' => 'Ropa deportiva para el día a día.'],
        ])->map(fn (array $cat) => Category::query()->updateOrCreate(
            ['slug' => Str::slug($cat['name'])],
            ['name' => $cat['name'], 'description' => $cat['description']]
        ));

        // ── Productos ────────────────────────────────────────────
        $products = [
            // Fitness
            [
                'name'        => 'Guantes de Entrenamiento',
                'description' => 'Guantes con agarre reforzado y muñequera.',
                'price'       => 19.99,
                'stock'       => 60,
                'active'      => true,
                'image'       => null,
                'categories'  => ['fitness'],
            ],
            [
                'name'        => 'Banda de Resistencia Set',
                'description' => 'Set de 5 bandas elásticas de distintas resistencias.',
                'price'       => 24.99,
                'stock'       => 80,
                'active'      => true,
                'image'       => null,
                'categories'  => ['fitness'],
            ],
            [
                'name'        => 'Esterilla Yoga/Pilates',
                'description' => 'Esterilla antideslizante 6mm de grosor.',
                'price'       => 34.99,
                'stock'       => 50,
                'active'      => true,
                'image'       => null,
                'categories'  => ['fitness'],
            ],
            // Running
            [
                'name'        => 'Camiseta Técnica Dry-Fit',
                'description' => 'Tejido transpirable de secado rápido.',
                'price'       => 29.99,
                'stock'       => 120,
                'active'      => true,
                'image'       => null,
                'categories'  => ['running'],
            ],
            [
                'name'        => 'Mallas de Compresión',
                'description' => 'Mallas largas con paneles de compresión muscular.',
                'price'       => 44.99,
                'stock'       => 75,
                'active'      => true,
                'image'       => null,
                'categories'  => ['running'],
            ],
            [
                'name'        => 'Calcetines Running Pack',
                'description' => 'Pack de 3 pares acolchados anti-rozadura.',
                'price'       => 12.99,
                'stock'       => 200,
                'active'      => true,
                'image'       => null,
                'categories'  => ['running'],
            ],
            // Lifestyle
            [
                'name'        => 'Sudadera Double Helix',
                'description' => 'Sudadera con capucha en rosa y negro.',
                'price'       => 59.99,
                'stock'       => 60,
                'active'      => true,
                'image'       => null,
                'categories'  => ['lifestyle'],
            ],
            [
                'name'        => 'Mochila Urban Sport 25L',
                'description' => 'Mochila con compartimento para portátil y zapatillas.',
                'price'       => 49.99,
                'stock'       => 35,
                'active'      => true,
                'image'       => null,
                'categories'  => ['lifestyle'],
            ],
            [
                'name'        => 'Botella Térmica 750ml',
                'description' => 'Acero inoxidable, mantiene frío 24h.',
                'price'       => 27.99,
                'stock'       => 90,
                'active'      => true,
                'image'       => null,
                'categories'  => ['lifestyle'],
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
