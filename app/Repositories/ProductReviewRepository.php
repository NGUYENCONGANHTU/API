<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductReviewRepository extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductReview::class;
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

        if (isset($params['product_id'])) {
            $query = $query->where('product_id', '=', (int) $params['product_id']);
        }

        if (isset($params['user_id'])) {
            $query = $query->where('user_id', '=', (int) $params['user_id']);
        }


        return $query->paginate($limit);
    }
}