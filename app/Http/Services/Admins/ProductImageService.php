<?php

namespace App\Http\Services\Admins;
use App\Repositories\ProductImageRepositories;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\Admins\BaseService;
use Exception;

class ProductImageService extends BaseService
{
    /**
     * @var Repository
     */
    protected $productImageRepositories;
  
    /**
     * Construct
     */
    public function __construct()
    {
        $this->productImageRepositories = new ProductImageRepositories();
    }

    /**
     * medias File productImage
     *
     * @param [type] $params
     * @return void
     */
    public function add($param)
    {
        try {
            //upload file_name
            $file = $param['file_name']->getClientOriginalName();
            $fileName = $this->fileName($file);
            $url = $param['file_name']->move(public_path("upload/subProduct/"), $fileName);
            $param['file_name'] = "upload/subProduct/" . $fileName;
            $this->checkFolder($url);
            $model = $this->productImageRepositories->create($param);
            return $model;
        } catch (\Throwable $th) {
            throw new Exception("Create product file name fail!!!");
        }
    }

     /**
     * medias File productImage
     * @param [type] $id
     * @param [type] $request
     * @return void
     */

     public function update($param)
     {
        $productImage = $this->productImageRepositories->findOrFail($param['id']);
        if(!$productImage){
            throw new Exception("get product file_name fail!!!");
        }
        if((int)$param['isUpload'] === 0){
            $param['file_name'] = $productImage->file_name;
        }else{
            // Upload file
        $path = "upload/subProduct/";
            if ($path.$param['file_name']->getClientOriginalName() !=  $productImage->file_name) {
                Storage::delete($productImage->file_name);
                $file = $param['file_name']->getClientOriginalName();
                $fileName = $this->fileName($file);
                $url = $param['file_name']->move(public_path($path), $fileName);
                $param['file_name'] = "upload/subProduct/" . $fileName;
                $this->checkFolder($url);
            } else {
                $param['file_name'] = $productImage->file_name;
            }
        }
        $model = $this->productImageRepositories->update($param, $productImage->id);
        return $model;
     }

     /**
     * delete productImage
     * @param [type] $id
     * @return void
     */
    public function delete($id){
        $productImage = $this->productImageRepositories->findOrFail($id);
        if(!$productImage){
            throw new Exception("get product image fail!!!");
        }
        $imagePath = storage_path('app/public/'. $productImage->file_name);
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
        $model = $this->productImageRepositories->delete($productImage->id);
        return $model;
    }
}
