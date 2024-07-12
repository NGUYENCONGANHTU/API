<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\OrderDetail;
use Exception;

class OrderDetailRepository extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderDetail::class;
    }

     /**
     * sync list category
     *
     * @param array $itemId
     * @return mixed
     */
    public function syncDataOrder($itemId)
    {
        try {
            if($itemId){
                return $this->model
                            ->where('id', $itemId)
                                    ->get();
            }
        } catch (\Throwable $th) {
           throw new Exception("sync data list order detail fail!!!");
        }
    }

}