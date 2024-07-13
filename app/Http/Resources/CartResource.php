<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\ProductAttributesRepositories;
use App\Repositories\ProductRepositories;
// use App\Http\Services\Admins\AttributesServices;
use App\Models\Product;
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $productRepositories = new ProductRepositories();
        $productAttributesRepositories = new ProductAttributesRepositories();
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'product' => $productRepositories->findOrFail( $this->product_id),
            'product_attribute_id' => $this->product_attribute_id,
            'productAttribute' => $productAttributesRepositories->cartProductAttributes($this->product_attribute_id),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total_cart' => $this->total_cart,
            'status' => $this->status,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}