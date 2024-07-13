<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Admins\Notification\NotificationResources;
use App\Repositories\NotificationRepository;

class NotificationController extends Controller {

    /**
     * @var Repository
     */
    protected $notificationRepository;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->notificationRepository = new NotificationRepository();
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

        $modelList = $this->notificationRepository->search($params);
        
        $jsonModel = NotificationResources::collection($modelList);
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
            $model = $this->notificationRepository->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }

        return response($model);
    }

}