<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderDetailResource;
use App\Repositories\OrderDetailRepository;

class OrderDetailController extends Controller {


     /**
     * @var Service
     */
    protected $orderDetailRepositories;
    protected $orderDetailService;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->orderDetailRepositories = new OrderDetailRepository();
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
            $params = $request->all();
            $modelList = $this->orderDetailRepositories->search( $params);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel =  OrderDetailResource::collection($modelList);
        return $jsonModel;
    }


    /**
    * deletEAll a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {   
        try {
            $model = $this->orderDetailRepositories->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        return response($model);
    }
}