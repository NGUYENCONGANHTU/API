<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\HistoryResource;
use App\Repositories\HistoryRepository;

class HistoryController extends Controller {

    /**
     * @var Repository
     */
    protected $historyRepository;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->historyRepository = new HistoryRepository();
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

        $modelList = $this->historyRepository->search($params);
        
        $jsonModel = HistoryResource::collection($modelList);
        return $jsonModel;
    }

}