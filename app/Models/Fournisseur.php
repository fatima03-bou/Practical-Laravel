<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $table = 'fournisseurs';
    protected $fillable=["raison_social","adresse","tele","email","description"];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
