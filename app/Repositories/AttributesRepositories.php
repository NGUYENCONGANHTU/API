<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ProductAttribute;
use Exception;

class AttributesRepositories extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductAttribute::class;
    }

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

        return $query->paginate($limit);
    }

    /**
     * Delete multiple db product images
     *
     * @param array $idProduct
     * @return mixed
     */
    public function deleteAttributes($idProduct)
    {
        try {
            $listAttributes = $this->model->where("product_id",$idProduct)->get();
            if($listAttributes){
                foreach($listAttributes as $item){
                    $item->delete();
                }
            }
        } catch (\Throwable $th) {
            throw new Exception("Error: delete attributes fail!!!");
        }
    }

    public function syncNameProduct($proAttributesId)
     {
        if($proAttributesId != null)
        {
            return $this->model->whereIn('id',$proAttributesId)->get(['name']);
        }
     }

     public function syncAttributesById($productId)
     {
        if($productId != null)
        {
            return $this->model->where('product_id',$productId)->orderBy('id', 'DESC')->get();
        }
     }

}