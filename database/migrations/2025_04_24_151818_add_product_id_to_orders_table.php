<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        $table->dropForeign(['product_id']); // Remove the foreign key first
        $table->dropColumn('product_id');
    });
}

};
