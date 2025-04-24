<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            // Ignorer l'en-tête
            if ($index === 0) continue;

            // Vérifie que le prix est numérique (peut être adapté selon besoin)
            if (!is_numeric($row[3])) continue;

            // Créer ou récupérer la catégorie
            $category = Category::firstOrCreate(['name' => $row[4]]);

            // Créer le produit
            Product::create([
                'name' => $row[0],
                'description' => $row[1],
                'image' => $row[2],
                'price' => $row[3],
                'category_id' => $category->id,
                'quantity_store' => $row[5],
                'fournisseur_id' => $row[6],
            ]);
        }
    }
}