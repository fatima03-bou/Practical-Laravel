<?php

namespace App\Imports;

use App\Models\Categorie;
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
        foreach ($collection as $row) {
            if (count($row) < 7) {
                continue;  
            }
            $category = Categorie::firstOrCreate(['name' => $row[4]]);

            Product::create([
                'name' => $row[0],              
                'description' => $row[1],   
                'image' => $row[2],              
                'price' => $row[3],              
                'categorie_id' => $category->id, 
                'quantity_store' => $row[5],    
                'fournisseur_id' => $row[6],     
            ]);
        }
    }
}