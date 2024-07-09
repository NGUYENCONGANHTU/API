<?php

namespace App\Http\Services\Admins;
use App\Repositories\ProductRepositories;
use App\Repositories\ProductImageRepositories;
use App\Repositories\AttributesRepositories;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\Admins\BaseService;
use Exception;

class ProductService extends BaseService
{
    /**
     * @var Repository
     */
    protected $productRepositories;
    protected $productImageRepositories;
    protected $attributesRepositories;
  
    /**
     * Construct
     */
    public function __construct()
    {
        $this->productRepositories = new ProductRepositories();
        $this->productImageRepositories = new ProductImageRepositories();
        $this->attributesRepositories = new AttributesRepositories();
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
            //save product
            $file = $param['images']->getClientOriginalName();
            $fileName = $this->fileName($file);
            $url = $param['images']->move(public_path("upload/products/"), $fileName);
            $param['images'] = "upload/products/" . $fileName;
            $this->checkFolder($url);
            $newProduct = $this->productRepositories->create($param);

            // save product images
            if($param['sub_img_details']){
                $productImage = [];

                foreach($param['sub_img_details'] as $itemFileNames)
                {
                    // convert file name
                    $fileNames = $this->fileName($itemFileNames->getClientOriginalName());
                    // add path
                    $url =  $itemFileNames->move(public_path('upload/subProduct/'), $fileNames);

                    $productImage['file_name'] = 'upload/subProduct/'.$fileNames;
                    $productImage['product_id'] = $newProduct['id'];
                    $productImage['status'] = $newProduct['status'];
                    $this->checkFolder($url);
                    // save db model product-images
                    $this->productImageRepositories->create($productImage);
                }
            }

            if($param['id_sub_product_attributes']){
                $attributes = [];
                // convert string to array
                $stringIdProductAttributesConvert = implode($param['id_sub_product_attributes']);
                if(explode(',', $stringIdProductAttributesConvert)){
                    foreach(explode(',', $stringIdProductAttributesConvert) as $itemId)
                    {
                        $attributes['product_id'] = $newProduct['id'];
                        $attributes['attribute_id'] = $itemId;
                        $this->attributesRepositories->create($attributes);
                    }
                }
            }
            return $newProduct;
        } catch (\Throwable $th) {
            throw new Exception("Create product fail!!!");
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
        $productImage = $this->productRepositories->findOrFail($param['id']);
        if(!$productImage){
            throw new Exception("get product images fail!!!");
        }
        if((int)$param['isUpload'] === 0){
            $param['images'] = $productImage->images;
        }else{
            // Upload file
        $path = "upload/products/";
            if ($path.$param['images']->getClientOriginalName() !=  $productImage->images) {
                Storage::delete($productImage->images);
                $file = $param['images']->getClientOriginalName();
                $fileName = $this->fileName($file);
                $url = $param['images']->move(public_path($path), $fileName);
                $param['images'] = "upload/products/" . $fileName;
                $this->checkFolder($url);
            } else {
                $param['images'] = $productImage->images;
            }
        }
        $model = $this->productRepositories->update($param, $productImage->id);
        return $model;
     }

     /**
     * delete productImage
     * @param [type] $id
     * @return void
     */
    public function delete($id){
        $product = $this->productRepositories->findOrFail($id);
        if(!$product){
            throw new Exception("get product image fail!!!");
        }
        $imagePath = storage_path('app/public/'. $product->images);
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
        // delete db
        $this->productImageRepositories->deleteSubImages($product->id);
        $this->attributesRepositories->deleteAttributes($product->id);
        $model = $this->productRepositories->delete($product->id);
        return $model;
    }
}
