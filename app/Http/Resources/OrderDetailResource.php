<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use App\Repositories\ProductAttributesRepositories;
// use App\Repositories\ProductRepositories;
class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $productRepositories = new ProductRepositories();
        // $productAttributesRepositories = new ProductAttributesRepositories();
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            //'product' => $productRepositories->findOrFail( $this->product_id),
            'product_attribute_id' => $this->product_attribute_id,
            //'productAttribute' => $productAttributesRepositories->cartProductAttributes($this->product_attribute_id),
            'quantity' => $this->quantity,
            'payment_mb_status_success' => $this->payment_mb_status_success,
            'status_payment_success' => $this->status_payment_success,
            'status_order' => $this->status_order,
            'status_order_confirmation' => $this->status_order_confirmation,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}