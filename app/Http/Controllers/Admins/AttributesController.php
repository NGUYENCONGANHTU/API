<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AttributesRepositories;
use App\Http\Services\Admins\AttributeService;
use App\Http\Resources\Admins\ProductAttributes\AttributeResource;
use App\Http\Resources\Admins\ProductAttributes\AdminAttributeResource;

class AttributesController extends Controller
{
    /**
     * @var Repository
     */
    protected $attributesServices;
    protected $attributesRepositories;
    /**
     * Construct
     */
    public function __construct()
    {
        $this->attributesServices = new AttributeService();
        $this->attributesRepositories = new AttributesRepositories();
    }

    /**
     * Get data by multiple fields.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        // $params = $request->all();
        // $params['conditions'] = $request->all();

        // $modelList = $this->attributesServices->getListAttributes($params);

        // $jsonModel = AttributeResource::collection($modelList);
        // return $jsonModel;
        $modelList = $this->attributesRepositories->search( $request->all());
        $jsonModel = AdminAttributeResource::collection($modelList);
        return $jsonModel;
    }

    /**
     * Get data by multiple fields.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelList = $this->attributesRepositories->findOrFail($id);
        $jsonModel = new AdminAttributeResource($modelList);
        return $jsonModel;
    }

     /**
     * Get data by multiple fields.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getList($productId)
    {
        $modelList = $this->attributesServices->getListAttributes($productId);
        $jsonModel = AttributeResource::collection($modelList);
        return $jsonModel;
    }

     /**
    * Store a newly created resource in storage.
    *
   * @param  App\Http\Requests\Banner\BannerRequests  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {   
       try {
           $model = $this->attributesServices->createAttributes($request->all());
       } catch (\Throwable $th) {
           return response()->json([
               'data' => ['errors' => ['exception' => $th->getMessage()]]
           ], 400);
       }
       $jsonModel = new AdminAttributeResource($model);
       return true;
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Banner\BannerRequests  $request
     * @param  int  $id - Model Id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            $params = $request->only('product_id','attribute_id');
            $model = $this->attributesRepositories->update($params,$id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new AdminAttributeResource($model);

        return $jsonModel;
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id - Model Id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = $this->attributesRepositories->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }

        return response($model);
    }
}
