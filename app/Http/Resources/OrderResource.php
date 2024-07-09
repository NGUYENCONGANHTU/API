<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use App\Repositories\UsersRepository;
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //$usersRepository = new UsersRepository();
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'order_id' => $this->order_id,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'name' =>  $this->name,
            'email' => $this->email,
            // 'user' =>  $usersRepository->userOrder($this->user_id),
            'status' => $this->status,
            'note' => $this->note,
            'order_pay_status' => $this->order_pay_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}