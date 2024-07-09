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
}