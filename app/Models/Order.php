<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    /**
     * ORDER ATTRIBUTES
     * $this->attributes['id'] - int - contains the order primary key (id)
     * $this->attributes['total'] - string - contains the order name
     * $this->attributes['user_id'] - int - contains the referenced user id
     * $this->attributes['created_at'] - timestamp - contains the order creation date
     * $this->attributes['updated_at'] - timestamp - contains the order update date
     * $this->user - User - contains the associated User
     * $this->items - Item[] - contains the associated items
     */
    use HasFactory;

    protected $fillable = [
        'total',
        'user_id',
        'status',
       "product_id"
    ];
     public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**

     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    
    public static function validate($request)
    {
        $request->validate([
            "total" => "required|numeric",
            "user_id" => "required|exists:users,id",
            "status" => "required|string",
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
