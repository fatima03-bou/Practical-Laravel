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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->float('rate', 5, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['product', 'category', 'global']);
            $table->foreignId('product_id')->nullable()->constrained()->OnDelete('cascade');
            $table->foreignId('categorie_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
