<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the column exists before adding it
        if (!Schema::hasColumn('products', 'categorie_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('categorie_id')->nullable();
            });
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']); // Drop the foreign key
            $table->dropColumn('categorie_id');
        });
    }
};
