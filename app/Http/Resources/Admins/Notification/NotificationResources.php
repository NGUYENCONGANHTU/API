<?php

namespace App\Http\Resources\Admins\Notification;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\UsersRepository;
use App\Repositories\OrderDetailRepository;
class NotificationResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $usersRepository = new UsersRepository();
        $orderDetailRepositories = new OrderDetailRepository();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'product_id' => $this->product_id,
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'description' => $this->description,
            'user' =>  $usersRepository->userNotification($this->user_id),
            'orderDetail' =>  $orderDetailRepositories->getOrderDetailByOrderId($this->order_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}