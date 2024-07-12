<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CartResource;
use App\Http\Services\CartService;
use App\Repositories\CartRepositories;

class CartController extends Controller {

    /**
     * @var Repository
     */
    protected $cartRepositories;
    protected $cartService;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->cartRepositories = new CartRepositories();
        $this->cartService = new CartService();
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
        $params['conditions'] = $request->all();

        $modelList = $this->cartRepositories->listCart($params);
        
        $jsonModel = CartResource::collection($modelList);
        return $jsonModel;
    }


    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request,$productId)
   {   
       try {
           $params = $request->all();
           $userId = Auth::guard('app-users')->user()->id;
           $model = $this->cartService->addToCart($params,$userId,$productId);
       } catch (\Throwable $th) {
           return response()->json([
               'data' => ['errors' => ['exception' => $th->getMessage()]]
           ], 400);
       }
       $jsonModel = new CartResource($model);

       return $jsonModel;
   }

   /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Category\CategoryRequest  $request
     * @param  int  $id - Model Id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$productId)
    {
        try {
            $params = $request->all();
            $userId = Auth::guard('app-users')->user()->id;
            $model = $this->cartService->updateCart($params,$userId,$productId);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new CartResource($model);

        return $jsonModel;
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id - Model Id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        try {
            $userId = Auth::guard('app-users')->user()->id;
            $model = $this->cartService->deleteCart($userId,$productId);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }

        return response($model);
    }

}