<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\OrderDetail;
use Exception;

class OrderDetailRepository extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderDetail::class;
    }

     /**
     * sync list category
     *
     * @param array $itemId
     * @return mixed
     */
    public function syncDataOrder($itemId)
    {
        try {
            if($itemId){
                return $this->model
                            ->where('id', $itemId)
                                    ->get();
            }
        } catch (\Throwable $th) {
           throw new Exception("sync data list order detail fail!!!");
        }
    }

    public function addOrderDetail($cart,$orderId){

        if($cart  == null && $orderId == null)
        {
            throw new Exception($cart+"does not exist and"+$orderId+"does not exist ");
        }

        $attribute = [];
        $attribute['product_id'] = $cart->product_id;
        $attribute['order_id'] = $orderId;
        $attribute['product_attribute_id'] = $cart->product_attribute_id;
        $attribute['quantity'] = $cart->quantity;
        $attribute['total'] = $cart->price * $cart->quantity;
        $attribute['status_payment_success'] = 1;
        $attribute['status_order'] = 1;
       
        return parent::create($attribute);
    }

    public function getOrderDetailByOrderId($orderId){

        if($orderId == null)
        {
            throw new Exception($orderId +" failed ");
        }
        $attributes = [];
        $result = $this->model->where('order_id',$orderId)->get();
        if($result){
            $attributes = $result;
        }   
        
        return $attributes;
    }

}