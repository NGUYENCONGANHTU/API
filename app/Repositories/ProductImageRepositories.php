<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductImageRepositories extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductImage::class;
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

        return $query->paginate($limit);
    }


    /**
     * Delete multiple db product images
     *
     * @param array $idProduct
     * @return mixed
     */
    public function deleteSubImages($idProduct)
    {
        try {
            $listImages = $this->model->where("product_id",$idProduct)->get();
            if($listImages){
                foreach($listImages as $item){
                    $imagePath = storage_path('app/public/'. $item->file_name);
                    if (Storage::exists($imagePath)) {
                        Storage::delete($imagePath);
                    }
                    $item->delete();
                }
            }
        } catch (\Throwable $th) {
            throw new Exception("Error: delete sub product images fail!!!");
        }
    }
}