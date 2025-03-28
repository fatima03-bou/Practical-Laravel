<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /**
     * PRODUCT ATTRIBUTES
     * $this->attributes['id'] - int - contains the product primary key (id)
     * $this->attributes['name'] - string - contains the product name
     * $this->attributes['description'] - string - contains the product description
     * $this->attributes['image'] - string - contains the product image
     * $this->attributes['price'] - int - contains the product price
     * $this->attributes['created_at'] - timestamp - contains the product creation date
     * $this->attributes['updated_at'] - timestamp - contains the product update date
     * $this->items - Item[] - contains the associated items
     */
    use HasFactory;
    protected $fillable = ['name', 'description', 'image', 'price', 'categorie_id', 'quantity_store',"fournisseur_id"];

    public static function validate($request)
    {
        $request->validate([
            "name" => "required|max:255",
            "description" => "required",
            "price" => "required|numeric|gt:0",
            'image' => 'nullable|image',
            "quantity_store" => "required|numeric|gt:1",  
            "categorie_id" => "required|exists:categories,id", 
            "fournisseur_id" => "required|exists:fournisseurs,id"
        ]);
    }

    public static function sumPricesByQuantities($products, $productsInSession)
    {
        $total = 0;
        foreach ($products as $product) {
            $total = $total + ($product->getPrice()*$productsInSession[$product->getId()]);
        }

        return $total;
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function setName($name)
    {
        $this->attributes['name'] = $name;
    }

    public function getDescription()
    {
        return $this->attributes['description'];
    }

    public function setDescription($description)
    {
        $this->attributes['description'] = $description;
    }

    public function getImage()
    {
        return $this->attributes['image'];
    }

    public function setImage($image)
    {
        $this->attributes['image'] = $image;
    }

    public function getPrice()
    {
        return $this->attributes['price'];
    }

    public function setPrice($price)
    {
        $this->attributes['price'] = $price;
    }


    public function getCreatedAt()
    {
        return $this->attributes['created_at'];
    }

    public function setCreatedAt($createdAt)
    {
        $this->attributes['created_at'] = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->attributes['updated_at'];
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->attributes['updated_at'] = $updatedAt;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function getCategoryieId(){
        return $this->attributes["categorie_id"];
    }
    public function setCategorieId($categorieId){
        return $this->attributes["categorie_id"]=$categorieId;
    }
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function getQuantityStore()
    {
        return $this->attributes['quantity_store'];
    }

    public function setQuantityStore($quantity_store)
    {
        $this->attributes['quantity_store'] = $quantity_store;
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
    public function hasDiscount()
    {
    return $this->discount_price && $this->discount_price < $this->price;
    }

    public function getDiscountedPrice()
    {
    return $this->discount_price ?? $this->price;
    }

}
