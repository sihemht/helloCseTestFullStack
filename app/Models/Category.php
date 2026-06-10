<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    //List champs simple
    protected $fillable = [
        'name',
        'image',
        'status',
        ];

    //Enum
    protected $casts = [
        'status' => CategoryStatus::class,
    ];

    //Relationship one category have many products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
