<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        // Check if the column exists first
        if (!Schema::hasColumn('orders', 'product_id')) {
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
        }
    });
}


public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        // Check if the product_id column exists
        if (Schema::hasColumn('orders', 'product_id')) {
            // Check if the foreign key exists using raw SQL
            $foreignKeyExists = DB::table('information_schema.key_column_usage')
                ->where('table_name', 'orders')
                ->where('column_name', 'product_id')
                ->exists();

            if ($foreignKeyExists) {
                // Drop the foreign key if it exists
                $table->dropForeign(['product_id']);
            }

            // Drop the column
            $table->dropColumn('product_id');
        }
    });
}

    
    };