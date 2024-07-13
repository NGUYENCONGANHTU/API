<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Services\OrderService;
use App\Repositories\CartRepositories;

class OrderController extends Controller {


     /**
     * @var Service
     */
    protected $orderService;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->orderService = new OrderService();
    }
    /**
     * Get data by multiple fields.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        try {
            $modelList = $this->orderService->setRowInformation();
            $jsonModel = new OrderResource($modelList);
            return $jsonModel;
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
    }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function checkOut(Request $request)
    {   
        try {
            $params = $request->all();
            $userId = Auth::guard('app-users')->user()->id;
            $model = $this->orderService->checkOut($userId,$params);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new OrderResource($model);
 
        return $jsonModel;
    }
}