<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Categorie;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'rate', 'start_date', 'end_date', 'category_id', 'product_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'rate' => 'float'
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isActive(): bool
    {
        $now = now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }
}