<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_category_stats');
        DB::statement('DROP VIEW IF EXISTS v_product_favorites');

        DB::statement("
            CREATE VIEW v_category_stats AS
            SELECT
                c.id,
                c.name,
                c.slug,
                c.description,
                (SELECT COUNT(*) FROM category_product WHERE category_id = c.id) AS product_count
            FROM categories c
        ");

        DB::statement("
            CREATE VIEW v_product_favorites AS
            SELECT
                p.id,
                p.name,
                p.price,
                p.image,
                p.stock,
                p.active,
                (SELECT COUNT(*) FROM favorites WHERE product_id = p.id) AS favorites_count
            FROM products p
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_category_stats');
        DB::statement('DROP VIEW IF EXISTS v_product_favorites');
    }
};
