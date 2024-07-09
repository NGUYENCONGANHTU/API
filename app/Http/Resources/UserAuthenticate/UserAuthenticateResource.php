<?php

namespace App\Http\Resources\UserAuthenticate;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserAuthenticateResource extends JsonResource
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
            'token' => $this['token'],
            'refreshToken' => $this['refreshToken'],
            'user' => [
                "id" => $this['user']->id,
                "email" =>  $this['user']->email,
                "avatar" =>  $this['user']->avatar,
                "gender_type" =>  $this['user']->gender_type,
                "full_name" =>  $this['user']->full_name,
                "parent_name" =>  $this['user']->parent_name,
                "country"=>  $this['user']->country,
                "city"=>  $this['user']->city,
                "address"=>  $this['user']->address,
                "phone_number"=>  $this['user']->phone_number,
                "zip_code"=>  $this['user']->zip_code,
                "age"=>  $this['user']->age,
                "account_type"=>  $this['user']->account_type,
                "user_name"=>  $this['user']->user_name,
                "platform"=>  $this['user']->platform,
                "version"=>  $this['user']->version,
                "ip"=>  $this['user']->ip,
                "agent"=>  $this['user']->agent,
                "status"=>  $this['user']->status,
                "refresh_token"=>  $this['user']->refresh_token,
                "created_at"=>  $this['user']->created_at,
                "updated_at"=>  $this['user']->updated_at,
            ],
            'serverTime' => (new DateTime())
        ];
    }
}