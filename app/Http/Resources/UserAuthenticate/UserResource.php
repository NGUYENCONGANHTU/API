<?php

namespace App\Http\Resources\UserAuthenticate;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'user_name' => $this->user_name,
            'gold' => $this->gold,
            'avatar' => $this->avatar,
            'full_name' => $this->full_name,
            'city' => $this->city,
            'address' => $this->address,
            'refresh_token' => $this->refresh_token,
            'ip' => $this->ip,
            'gender_type' => $this->gender_type,
            'full_name' => $this->full_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'account_type' => $this->account_type,
            'status' => $this->status,
            'country' => $this->country,
            'token' => $this->token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}