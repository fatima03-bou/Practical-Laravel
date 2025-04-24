<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'user_id', 'status'];

    public static function validate($request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getTotalPrice()
    {
        return $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }
}
