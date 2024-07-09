<?php

namespace App\Http\Services\Admins;
use App\Repositories\AttributesRepositories;
use App\Repositories\ProductAttributesRepositories;
use App\Http\Services\Admins\BaseService;
use Exception;

class AttributeService extends BaseService
{
    /**
     * @var Repository
     */
    protected $attributesRepositories;
    protected $productAttributesRepositories;
  
    /**
     * Construct
     */
    public function __construct()
    {
        $this->attributesRepositories = new AttributesRepositories();
        $this->productAttributesRepositories = new ProductAttributesRepositories();
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
                $responseData = [];

                $listAttributes = $this->attributesRepositories->where('id', $itemId)->get();
                foreach($listAttributes as $item){
                    $dataProductAttributes = $this->productAttributesRepositories->syncData($item->attribute_id);
                    $responseData[] = [
                        'attribute_id' => $item->attribute_id,
                        'product_id' => $item->product_id,
                        'name' => $dataProductAttributes->name,
                        'status' => $dataProductAttributes->status,
                        'value' =>   $dataProductAttributes->value
                    ];
                }            
                 
                return $responseData;
            }
        } catch (\Throwable $th) {
           throw new Exception("sync data list category fail!!!");
        }
    }
    
}
