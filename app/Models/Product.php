<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Category;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'category_id',
        'fournisseur_id',
    ];

    public static function validate($request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|gt:0',
            'image' => 'image',
        ]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function getDiscountedPrice()
    {
        if ($this->isDiscountActive()) {
            return $this->price - ($this->price * $this->discount->percentage / 100);
        }
        return $this->price;
    }

    public function getFormattedDiscountedPrice()
    {
        return number_format($this->getDiscountedPrice(), 2);
    }

    public function isDiscountActive()
    {
        $discount = $this->discount;
        $now = now();

        return $discount && $now >= $discount->start_date && $now <= $discount->end_date;
    }
}
