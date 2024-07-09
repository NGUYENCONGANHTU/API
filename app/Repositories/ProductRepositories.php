<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Product;
use Exception;

class ProductRepositories extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
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
        $query = $this->model->query();

        if (isset($params['status'])) {
            $query = $query->where('status', '=', (int) $params['status']);
        }

        if (isset($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        if (isset($params['category_id'])) {
            $query = $query->where('category_id', '=', (int) $params['category_id']);
        }

        if (isset($params['trademark_id'])) {
            $query = $query->where('trademark_id', '=', (int) $params['trademark_id']);
        }

        if (isset($params['sort'])) {
            $params['sortType'] = $params['sort'];
            if(!empty($params['sortType'])){
                $this->orderBy('id', $params['sortType']);
            }
        }

        if (isset($params['sortPrice'])) {
            $params['sortType'] = $params['sortPrice'];
            if(!empty($params['sortType'])){
                $this->orderBy('price', $params['sortType']);
            }
        }

        if (isset($params['sale_price'])) {
            $query = $query->where('sale_price', '>', (int)0);
        }

        return $query->paginate($limit);
    }
}