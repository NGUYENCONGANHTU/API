<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrdersRepository;
use App\Http\Resources\UserAuthenticate\UserResource;

class OrderController extends Controller
{
    /**
     * @var Repository
     */
    protected $orderRepositories;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->orderRepositories = new OrdersRepository();
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
        
        $modelList = $this->orderRepositories->search($params);
        
        $jsonModel = UserResource::collection($modelList);

        return $jsonModel;
    }

}