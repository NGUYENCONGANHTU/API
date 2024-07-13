<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\History;
use Exception;

class HistoryRepository extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return History::class;
    }

    /**
     * Get data by multiple fields
     *
     * @param array $params 
     * @return mixed
     */
    public function search($params)
    {
        // default limit
        $limit = config('constant.defaultLimit');
        $query = $this->model->query(); // list model


        if (isset($params['created_at'])) {
            $query->where('created_at', 'like', '%'.$params['created_at'].'%');
        }

        if (isset($params['status'])) {
            $query = $query->where('status', '=', (int) $params['status']);
        }

        if (isset($params['user_id'])) {
            $query = $query->where('user_id', '=', (int) $params['user_id']);
        }

        return $query->paginate($limit); // list
    }

    public function addHistoryCart($cart,$productName){
        if($cart == null && $productName == null){
            throw new Exception($cart+"does not exist and"+$productName+"does not exist ");
        }
      
        $attribute = [];
        $attribute['product_id'] = $cart->product_id;
        $attribute['user_id'] = $cart->user_id;
        $attribute['product_name'] = $productName;
        $attribute['product_attribute_id'] = $cart->product_attribute_id;
        $attribute['cart_id'] = $cart->id;
        $attribute['order_status'] = 1;
        $attribute['order_pay_status'] = 1;
        $attribute['quantity'] = $cart->quantity;
        $attribute['total'] = $cart->quantity * $cart->price;
        $attribute['status'] = $cart->status;

        return parent::create($attribute);
    }

    public function updateStatusHistory($cartId,$request){
        
        $history = $this->model->where('cart_id',$cartId)->orderBy('created_at', 'desc')->first();
        if($history == null){
            throw new Exception($history + "does not exist ");
        }

        if(config('constant.requestPayMB') == $request){
            $attribute = [];
            $attribute['order_status'] = config('constant.orderActive.statusOrder');
            $attribute['order_pay_status'] = config('constant.orderActive.orderPayStatus');
            return parent::update($attribute,$history->id);
        }else{
            $attribute = [];
            $attribute['order_status'] = config('constant.orderActive.statusOrder');
            return parent::update($attribute,$history->id);
        }
       
    }
}