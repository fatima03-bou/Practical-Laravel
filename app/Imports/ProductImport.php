<?php

namespace App\Imports;

use App\Models\Categorie;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;


class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
<<<<<<< HEAD
        foreach ($collection as $index => $row) {
            // Ignorer l'en-tête
            if ($index === 0) continue;

            // Vérifie que le prix est numérique (peut être adapté selon besoin)
            if (!is_numeric($row[3])) continue;

            // Créer ou récupérer la catégorie
            $category = Category::firstOrCreate(['name' => $row[4]]);

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
=======
        $category = Categorie::firstOrCreate(['name' => $row[4]]);

        return new Product([
            'name' => $row[0],        
            'description' => $row[1], 
            'image' => $row[2],      
            'price' => $row[3],  
            "quantity_store"=>[5]??0,
            'categorie_id' => $category->id,    
        ]);
>>>>>>> origin
    }
}
