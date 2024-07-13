<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Attribute;
use Exception;

class ProductAttributesRepositories extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Attribute::class;
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

        if (isset($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        if (isset($params['value'])) {
            $query->where('value', 'like', '%' . $params['value'] . '%');
        }

        if (isset($params['status'])) {
            $query = $query->where('status', '=', (int) $params['status']);
        }

        return $query->paginate($limit);
    }

    /**
     * sync Data 
     * @param array $params
     * @return mixed
     */
    public function syncData($itemId)
    {
        if($itemId){
            return $this->model
                    ->whereIn('id',$itemId)
                        ->get(['name', 'value', 'status']);
        }
    }

    public function syncNameProductAttributes($proAttributesId)
      {
         if($proAttributesId != null)
         {
            $attributes = [];
            $result = $this->model->whereIn('id',$proAttributesId)->get(['id','value','status','name']);
            if($result){
                $attributes = $result;
            }   
           
            return $attributes;
         }
      }

      public function getProductAttributes($proAttributesId)
      {
        
         if($proAttributesId != null)
         {
            $attributes = [];
            $result = $this->model->where('id',$proAttributesId)->first();
            if($result){
                $attributes = $result;
            }   
           
            return $attributes;
         }
      }

      public function cartProductAttributes($proAttributesId)
      {
         if($proAttributesId != null)
         {
            $attributes = [];
            foreach (explode(',', $proAttributesId ) as $attributeId) {
                $result = $this->model->where('id',$attributeId)->first();
                $attributes[] = $result;
            }
            return $attributes;
         }
      }
}