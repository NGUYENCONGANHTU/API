<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Exception;

class CartRepositories extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cart::class;
    }

    /**
     * Get data by multiple fields
     *
     * @param array $params 
     * @return mixed
     */
    public function search($params)
    {
      
        $limit = 0;
        if(isset($params['limit'])){
            $limit = $params['limit'];
        }else{
            $limit = config('constant.defaultLimit');
        }
        
        $query = $this->model->query();

        if (isset($params['user_id'])) {
            $query = $query->where('user_id', '=', (int) $params['user_id']);
        }
        if (isset($params['product_id'])) {
            $query = $query->where('product_id', '=', (int) $params['product_id']);
        }
        if (isset($params['status'])) {
            $query = $query->where('status', '=', (int) $params['status']);
        }

        return $query->paginate($limit);
    }

}