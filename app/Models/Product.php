<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Categorie;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'price', 'categorie_id'];

    // ✅ Validation statique
    public static function validate($request)
    {
        $request->validate([
            "name" => "required|max:255",
            "description" => "required",
            "price" => "required|numeric|gt:0",
            'image' => 'image',
            "categorie_id" => "required|exists:categories,id"
        ]);
    }

    // ✅ Calcul du total avec les quantités
    public static function sumPricesByQuantities($products, $productsInSession)
    {
        $total = 0;
        foreach ($products as $product) {
            $total += $product->getDiscountedPrice() * $productsInSession[$product->getId()];
        }
        return $total;
    }

    // ✅ Getters/Setters
    public function getId() { return $this->attributes['id']; }
    public function setId($id) { $this->attributes['id'] = $id; }

    public function getName() { return $this->attributes['name']; }
    public function setName($name) { $this->attributes['name'] = $name; }

    public function getDescription() { return $this->attributes['description']; }
    public function setDescription($description) { $this->attributes['description'] = $description; }

    public function getImage() { return $this->attributes['image']; }
    public function setImage($image) { $this->attributes['image'] = $image; }

    public function getPrice() { return $this->attributes['price']; }
    public function setPrice($price) { $this->attributes['price'] = $price; }

    public function getCreatedAt() { return $this->attributes['created_at']; }
    public function setCreatedAt($createdAt) { $this->attributes['created_at'] = $createdAt; }

    public function getUpdatedAt() { return $this->attributes['updated_at']; }
    public function setUpdatedAt($updatedAt) { $this->attributes['updated_at'] = $updatedAt; }

    public function getCategorieId() { return $this->attributes["categorie_id"]; }
    public function setCategorieId($categorieId) { $this->attributes["categorie_id"] = $categorieId; }

    // ✅ Relations
    public function items(): HasMany { return $this->hasMany(Item::class); }
    public function getItems() { return $this->items; }
    public function setItems($items) { $this->items = $items; }

    public function categorie(): BelongsTo { return $this->belongsTo(Categorie::class, 'categorie_id'); }

    public function discounts(): HasMany { return $this->hasMany(Discount::class); }

    // ✅ Discounts logic
    public function getActiveDiscount()
    {
        $now = now();

        // Produit spécifique
        $productDiscount = Discount::where('product_id', $this->id)
            ->where('type', 'product')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderByDesc('rate')
            ->first();

        if ($productDiscount) return $productDiscount;

        // Catégorie
        $categoryDiscount = Discount::where('category_id', $this->categorie_id)
            ->where('type', 'category')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderByDesc('rate')
            ->first();

        if ($categoryDiscount) return $categoryDiscount;

        // Globale
        return Discount::whereNull('product_id')
            ->whereNull('category_id')
            ->where('type', 'global')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderByDesc('rate')
            ->first();
    }

    public function hasDiscount(): bool
    {
        return $this->getActiveDiscount() !== null;
    }

    public function getDiscountedPrice()
    {
        $discount = $this->getActiveDiscount();

        if (!$discount) return $this->price;

        return $this->price * (1 - ($discount->rate / 100));
    }
}
