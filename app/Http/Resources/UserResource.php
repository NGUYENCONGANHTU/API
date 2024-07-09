<?php

namespace App\Http\Resources;

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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->avatar,
            'full_name' => $this->full_name,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'password' => $this->password,
            'age' => $this->age,
            'user_name' => $this->user_name,
            'version' => $this->version,
            'refresh_token' => $this->refresh_token,
            'ip' => $this->ip,
            'otp' => $this->otp,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'token' => $this->token,
        ];
    }
}