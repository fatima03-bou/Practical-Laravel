<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{

    protected $table = 'fournisseurs';
    protected $fillable=["raison","social","adresse","tele","email","description"];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
