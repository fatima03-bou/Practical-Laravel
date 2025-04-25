<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
<<<<<<< HEAD
            if (!Schema::hasColumn('products', 'quantity_store')) {
                $table->integer('quantity_store')->default(0)->after('price');
            }
=======
            $table->integer('quantity_store')->default(0)->after('price');
>>>>>>> origin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<< HEAD
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('quantity_store');
=======
<<<<<<< HEAD:database/migrations/2025_04_22_004019_add_type_to_discounts_table.php
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn(['type', 'category_id']);
=======
        Schema::table('products', function (Blueprint $table) {
            //
>>>>>>> 39d86d0e895ae945a9fb013d0fe2904cf1e2fcc2:database/migrations/2025_03_08_144552_add_column_to_table.php
>>>>>>> origin
        });
    }
};
