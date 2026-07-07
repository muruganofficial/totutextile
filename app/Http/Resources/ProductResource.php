<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'fabric_type' => $this->fabric_type,
            'description' => $this->description,
            'selling_price' => (float)$this->selling_price,
            'gst_rate' => (float)$this->gst_rate,
            'attributes' => $this->attributes,
            'collections' => $this->collections,
            'is_featured' => (bool)$this->is_featured,
            'is_trending' => (bool)$this->is_trending,
            'is_best_seller' => (bool)$this->is_best_seller,
            'is_new_arrival' => (bool)$this->is_new_arrival,
            'status' => $this->status,
            'brand' => [
                'name' => $this->brand->name ?? null,
                'slug' => $this->brand->slug ?? null,
            ],
            'category' => [
                'name' => $this->category->name ?? null,
                'slug' => $this->category->slug ?? null,
            ],
        ];
    }
}
