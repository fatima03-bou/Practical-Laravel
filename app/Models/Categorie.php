<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural of the model name
    protected $table = 'categories';
    protected $fillable=["name","description"];
    public function products(){
        return $this->hasMany(Product::class, "categorie_id");
    }

}
