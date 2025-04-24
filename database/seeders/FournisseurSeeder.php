<?php

namespace Database\Seeders;

use App\Models\fournisseur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FournisseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        fournisseur::factory()->count(10)->create();
    }
}
