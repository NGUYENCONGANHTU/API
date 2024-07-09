<?php

namespace App\Http\Resources\Admins\Product;

 use App\Http\Services\Admins\AttributeService;
use App\Repositories\TrademarkRepositories;
use App\Repositories\CategoryRepositories;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $trademarkRepositories = new TrademarkRepositories();
        $categoryRepositories = new CategoryRepositories();
        $attributesProduct = new AttributeService();
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'images' => $this->images,
            'slug' => $this->slug,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'category_id' => $this->category_id,
            'category' => $categoryRepositories->syncDataCategory($this->category_id),
            'trademark_id' => $this->trademark_id,
            'trademark' => $trademarkRepositories->syncDataTrademark($this->trademark_id),
            'is_view' => $this->is_view,
            'is_purchases' => $this->is_purchases,
            'star' => $this->star,
            'heart' => $this->heart,
            'type' => $this->type,
            'status' => $this->status,
            'attributes' => $attributesProduct->syncDataAttributes($this->id),
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}