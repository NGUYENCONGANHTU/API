<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderDetailRepository;
use App\Http\Resources\Admins\OrderDetail\OrderDetailResource;
use App\Http\Resources\UserAuthenticate\UserResource;

class OrderDetailController extends Controller
{
    /**
     * @var Repository
     */
    protected $orderDetailRepositories;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->orderDetailRepositories = new OrderDetailRepository();
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
            $model = $this->orderDetailRepositories->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonModel = new OrderDetailResource($model);

        return $jsonModel;
    }

}