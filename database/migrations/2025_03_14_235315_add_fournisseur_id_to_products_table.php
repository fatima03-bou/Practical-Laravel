<?php

use App\Models\fournisseur;
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
<<<<<<< HEAD
        if (!Schema::hasColumn('products', 'fournisseur_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('fournisseur_id');
                $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');
            });
        }
=======
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId("fournisseur_id")->constrained("fournisseurs")->cascadeOnDelete() ;
        });
>>>>>>> origin
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['fournisseur_id']);
            $table->dropColumn('fournisseur_id');
        });
    }
};
