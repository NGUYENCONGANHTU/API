<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BannerRequests;
use App\Repositories\ProductImageRepositories;
use App\Http\Resources\Admins\Product\ProductImagesResources;
use App\Http\Services\Admins\ProductImageService;

class ProductImageController extends Controller
{
    /**
     * @var Repository
     */
    protected $productImageRepositories;
    protected $productImageService;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->productImageRepositories = new ProductImageRepositories();
        $this->productImageService = new ProductImageService();
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
        
        $modelList = $this->productImageRepositories->search($params);
        
        $jsonModel = ProductImagesResources::collection($modelList);

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
            $model = $this->productImageRepositories->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new ProductImagesResources($model);

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
           $model = $this->productImageService->add($request->all());
       } catch (\Throwable $th) {
           return response()->json([
               'data' => ['errors' => ['exception' => $th->getMessage()]]
           ], 400);
       }
       $jsonModel = new ProductImagesResources($model);

       return $jsonModel;
   }

     /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Banner\BannerRequests  $request
     * @param  int  $id - Model Id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $model = $this->productImageService->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new ProductImagesResources($model);

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
            $model = $this->productImageRepositories->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }

        return response($model);
    }
}
