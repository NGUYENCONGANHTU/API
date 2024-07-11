<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductAttributesRepositories;
use App\Http\Resources\Admins\Attributes\AttributeResource;

class ProductAttributesController extends Controller
{
    /**
     * @var Repository
     */
    protected $ProductAttributesRepositories;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->ProductAttributesRepositories = new ProductAttributesRepositories();
    }
    

    /**
     * Get data by multiple fields.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $params = $request->all();
        
        $modelList = $this->ProductAttributesRepositories->search($params);
        
        $jsonModel = AttributeResource::collection($modelList);

        return $jsonModel;
    }

    /**
     * Get Object By Id.
     *
     * @param  int  $id - Model Id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $model = $this->ProductAttributesRepositories->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new AttributeResource($model);

        return $jsonModel;
    }

    /**
    * Store a newly created resource in storage.
    *
   * @param  App\Http\Requests\Banner\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {   
       try {
           $model = $this->ProductAttributesRepositories->create($request->all());
       } catch (\Throwable $th) {
           return response()->json([
               'data' => ['errors' => ['exception' => $th->getMessage()]]
           ], 400);
       }
       $jsonModel = new AttributeResource($model);

       return $jsonModel;
   }

     /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Banner\Request  $request
     * @param  int  $id - Model Id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $model = $this->ProductAttributesRepositories->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new AttributeResource($model);

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
            $model = $this->ProductAttributesRepositories->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }

        return response($model);
    }
}
