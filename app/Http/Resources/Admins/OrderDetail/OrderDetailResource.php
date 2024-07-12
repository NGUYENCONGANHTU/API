<?php

namespace App\Http\Resources\Admins\Orders;

use Illuminate\Http\Resources\Json\JsonResource;
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
        return [
            'id' => $this->id,
            'order_id'=>$this->order_id,
            'product_id' => $this->product_id,
            'product_attribute_id' => $this->product_attribute_id,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'status_order' => $this->status_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,  
            'status_payment_success' => $this->status_payment_success,  
        ];
    }
}