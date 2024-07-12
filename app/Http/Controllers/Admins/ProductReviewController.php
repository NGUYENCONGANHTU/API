<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductReviewRepository;
use App\Http\Resources\UserAuthenticate\UserResource;

class ProductReviewController extends Controller
{
    /**
     * @var Repository
     */
    protected $productReviewRepositories;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->productReviewRepositories = new ProductReviewRepository();
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
        
        $modelList = $this->productReviewRepositories->search($params);
        
        $jsonModel = UserResource::collection($modelList);

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
            $model = $this->productReviewRepositories->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new UserResource($model);

        return $jsonModel;
    }

}