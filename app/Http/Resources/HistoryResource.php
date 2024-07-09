<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'product_name' => $this->product_name,
            'product_attribute_id' => $this->product_attribute_id,
            'cart_id' => $this->cart_id,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'status' => $this->status,
            'order_status' => $this->order_status,
            'order_pay_status' => $this->order_pay_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}