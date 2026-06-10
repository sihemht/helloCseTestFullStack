<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image_url" => $this->image ? Storage::url($this->image) : null,
            "online_product" => $this->whenCounted('products'),
            "created_at" => $this->created_at?->toIso8601String(),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
