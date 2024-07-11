<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepositories;
use App\Http\Resources\Admins\Category\CategoryResource;

class CategoryController extends Controller
{
    /**
     * @var Repository
     */
    protected $categoryRepositories;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->categoryRepositories = new CategoryRepositories();
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
        
        $modelList = $this->categoryRepositories->search($params);
        
        $jsonModel = CategoryResource::collection($modelList);

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
            $model = $this->categoryRepositories->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new CategoryResource($model);

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
           $model = $this->categoryRepositories->create($request->all());
       } catch (\Throwable $th) {
           return response()->json([
               'data' => ['errors' => ['exception' => $th->getMessage()]]
           ], 400);
       }
       $jsonModel = new CategoryResource($model);

       return $jsonModel;
   }

     /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Banner\Request  $request
     * @param  int  $id - Model Id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            $model = $this->categoryRepositories->update($request->all(),$id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new CategoryResource($model);

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
            $model = $this->categoryRepositories->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }

        return response($model);
    }
}