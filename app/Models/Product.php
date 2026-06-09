<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    //List champs simple
     protected $fillable = [
         'name',
         'price',
         'image',
         'status',
         'category_id'
     ];

    //Enum
     protected $casts = [

         'price'=> 'float',
         'status' => ProductStatus::class,
     ];

     //Relationship one product have one category
     public function category(): BelongsTo
     {
         return $this->belongsTo(Category::class);
     }
}
