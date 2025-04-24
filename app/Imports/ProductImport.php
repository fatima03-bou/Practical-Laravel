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
        $category = Categorie::firstOrCreate(['name' => $row[4]]);

        return new Product([
            'name' => $row[0],        
            'description' => $row[1], 
            'image' => $row[2],      
            'price' => $row[3],  
            "quantity_store"=>[5]??0,
            'categorie_id' => $category->id,    
        ]);
    }
}
