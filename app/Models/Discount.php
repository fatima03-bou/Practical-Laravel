<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Product;

class Discount extends Model
{
    protected $fillable = ['type', 'category_id', 'product_id', 'percentage', 'start_date', 'end_date'];

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

