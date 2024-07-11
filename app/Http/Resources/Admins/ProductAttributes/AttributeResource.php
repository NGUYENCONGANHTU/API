<?php

namespace App\Http\Resources\Admins\ProductAttributes;

use App\Repositories\ProductAttributesRepositories;
use App\Repositories\ProductRepositories;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
            'product' => $this->product,
            'name' => $this->name,
            'product_attribute_id' => $this->product_attribute_id,
            //'product_attribute' => $productAttributesRepositories->getNameProductAttributes($this->product_attribute_id),
            'productAttribute' => $this->productAttribute,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}