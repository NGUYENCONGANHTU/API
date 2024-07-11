<?php

namespace App\Http\Resources\Admins\ProductAttributes;

use App\Repositories\ProductAttributesRepositories;
use App\Repositories\ProductRepositories;
use Illuminate\Http\Resources\Json\JsonResource;
class AdminAttributeResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product' => $productRepositories->productAttributes($this->product_id),
            'attribute_id' => $this->attribute_id,
            'product_attribute' => $productAttributesRepositories->getProductAttributes($this->attribute_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}