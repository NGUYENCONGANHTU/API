<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Users;
use Exception;
use Carbon\Carbon;

class UsersRepository extends BaseRepository
{
     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Users::class;
    }

    /**
     * Get data by multiple fields
     *
     * @param array $params
     * @return mixed
     */
    public function search($params)
    {
        // default limit
        $limit = config('constant.defaultLimit');
        $query = $this->model->query();

        if (isset($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        if (isset($params['email'])) {
            $query->where('email', 'like', '%' . $params['email'] . '%');
        }

        if (isset($params['userName'])) {
            $query->where('user_name', 'like', '%' . $params['userName'] . '%');
        }

        if (isset($params['phoneNumber'])) {
            $query->where('phone_number', 'like', '%' . $params['phoneNumber'] . '%');
        }

        if (isset($params['status'])) {
            $query = $query->where('status', '=', (int) $params['status']);
        }

        return $query->paginate($limit);
    }

    /**
     * Get Total User
     * @param array $params
     * @return mixed
     */
    public function getTotalUser()
    {
        return count($this->model->get());
    }

    /**
     * Generate auto number
     *
     * @param integer $length
     * @return void
     */
    function generateRandomString($length = 6)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * User Login
     *
     * @param array $params 
     * @return mixed
     */
    public function userLogin($request){
        try {
            $user = $this->model->where('email', '=', $request['email'])->first();
            if($user != null){
                $user['refresh_token'] = md5($request['phone_number'] . ($request['email'] != null ? $request['email'] : '') . config('constant.keySecret') . Carbon::now());
                $this->update($user->only('refresh_token'), $user['id']);
                return $user;
            }
            throw new Exception("Email or password incorrect");
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

     /**
     * Refresh Token
     *
     * @param array $params 
     * @return mixed
     */
    public function updateRefreshToken($request){
        try {
            $user = $this->model->where('refresh_token', '=', $request['refresh_token'])->first();
            if($user != null){
                $user['refresh_token'] = md5($request['phone_number'] . ($request['email'] != null ? $request['email'] : '') . config('constant.keySecret') . Carbon::now());
                $this->update($user->only('refresh_token'), $user['id']);
                return $user;
            }
            throw new Exception("refresh_token incorrect");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function userNotification($userId)
    {
        if($userId != null)
        {
            return$this->model->where('id',$userId)->get();
        }else{
            throw new Exception(" User does not exist ");
        }
    }

}