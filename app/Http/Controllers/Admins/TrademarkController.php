<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TrademarkRepositories;
use App\Http\Resources\Admins\Trademark\TrademarkResource;

class TrademarkController extends Controller
{
    /**
     * @var Repository
     */
    protected $trademarkRepositories;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->trademarkRepositories = new TrademarkRepositories();
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
        
        $modelList = $this->trademarkRepositories->search($params);
        
        $jsonModel = TrademarkResource::collection($modelList);

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
            $model = $this->trademarkRepositories->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new TrademarkResource($model);

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
           $model = $this->trademarkRepositories->create($request->all());
       } catch (\Throwable $th) {
           return response()->json([
               'data' => ['errors' => ['exception' => $th->getMessage()]]
           ], 400);
       }
       $jsonModel = new TrademarkResource($model);

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
            $model = $this->trademarkRepositories->update($request->all(),$id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new TrademarkResource($model);

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
            $model = $this->trademarkRepositories->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }

        return response($model);
    }
}