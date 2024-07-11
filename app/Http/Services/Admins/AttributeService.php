<?php

namespace App\Http\Services\Admins;
use App\Repositories\AttributesRepositories;
use App\Repositories\ProductAttributesRepositories;
use App\Repositories\ProductRepositories;;
use App\Http\Services\Admins\BaseService;
use Exception;

class AttributeService extends BaseService
{
    /**
     * @var Repository
     */
    protected $attributesRepositories;
    protected $productAttributesRepositories;
    protected $productRepositories;
    /**
     * Construct
     */
    public function __construct()
    {
        $this->attributesRepositories = new AttributesRepositories();
        $this->productAttributesRepositories = new ProductAttributesRepositories();
        $this->productRepositories = new ProductRepositories();
    }


    /**
     * sync list product attributes
     *
     * @param array $itemId
     * @return mixed
     */
    public function syncDataAttributes($itemId)
    {
        try {
            if($itemId){
                $listAttributes = $this->attributesRepositories->syncAttributesById($itemId);
                if($listAttributes == null)
                {
                    $listAttributes = [];
                }

                $this->listAttributes($listAttributes);
                return $listAttributes;
                
            }
        } catch (\Throwable $th) {
           throw new Exception("sync data list category fail!!!");
        }
    }

    public function listAttributes($listAttributes)
    {
       $totalItemId = [];
      
       foreach($listAttributes as $itemId)
       {
           $totalItemId[] = $itemId->product_id;
           $totalItemId[] = $itemId->attribute_id;  
       }
       $allItemProduct = $this->productRepositories->syncNameProduct($totalItemId);
       $allItemProductAttribute = $this->productAttributesRepositories->syncNameProductAttributes($totalItemId);
       foreach($listAttributes as $itemId)
       {
           $itemId['product'] = '';
           $itemId['productAttribute'] = '';
           foreach( $allItemProduct as $product)
           {
               if ($itemId->product_id == $product->id) {
                   $itemId['product'] = $product['name'];
               }
           }
           foreach( $allItemProductAttribute as $productAttribute)
           {
               if ($itemId->attribute_id == $productAttribute->id) {
                   $itemId['productAttribute'] = $productAttribute;
               }
           }
       }

       return $listAttributes;
       
    }
    
    public function createAttributes($params) {
        $attributes = [];
        $stringIdProductAttributesConvert = implode($params['id_sub_product_attributes']);
        if(explode(',', $stringIdProductAttributesConvert)){
            foreach(explode(',', $stringIdProductAttributesConvert) as $item) {
                $attributes['product_id'] = $params['product_id'];
                $attributes['attribute_id'] = $item;
                $this->attributesRepositories->create($attributes);
            }
        }
       
        return  $attributes;
    }
}
