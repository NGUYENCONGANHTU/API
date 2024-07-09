<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BannerRequests;
use App\Repositories\NewsRepositories;
use App\Http\Resources\Admins\Banner\BannerResource;
use App\Http\Services\Admins\NewsService;

class NewsController extends Controller
{
    /**
     * @var Repository
     */
    protected $newRepositories;
    protected $newService;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->newRepositories = new NewsRepositories();
        $this->newService = new NewsService();
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
        
        $modelList = $this->newRepositories->search($params);
        
        $jsonModel = BannerResource::collection($modelList);

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
            $model = $this->newRepositories->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new BannerResource($model);

        return $jsonModel;
    }

    /**
    * Store a newly created resource in storage.
    *
   * @param  App\Http\Requests\Banner\BannerRequests  $request
    * @return \Illuminate\Http\Response
    */
   public function store(BannerRequests $request)
   {   
       try {
           $model = $this->newService->add($request->all());
       } catch (\Throwable $th) {
           return response()->json([
               'data' => ['errors' => ['exception' => $th->getMessage()]]
           ], 400);
       }
       $jsonModel = new BannerResource($model);

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
            $model = $this->newService->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new BannerResource($model);

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
            $model = $this->newService->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }

        return response($model);
    }
}
