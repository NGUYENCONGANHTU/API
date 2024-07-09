<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

class AdminRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     *
     */
    public function boot()
    {
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
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

        if (isset($params['status'])) {
            $query = $query->where('status', '=', (int) $params['status']);
        }

        return $query->paginate($limit);
    }

    /**
     * Save a new user in repository
     *
     * @param array $attributes
     * @return mixed
     */

    public function create(array $attributes)
    {
        $checkEmail =  $this->model->where('email', $attributes['email'])->get()->count();
        if ($checkEmail > 0) {
            throw new Exception("Email already exist..!");
        }
        $attributes['password'] = Hash::make($attributes['password']);

        return $this->model->create($attributes);
    }

    /**
     * Change Password in repository
     *
     * @param array $attributes
     * @return mixed
     */
    public function changePassword(array $attributes, $id)
    {
        if($attributes != null)
        {
            if (isset($attributes['password'])) {
                $attributes['password'] = Hash::make($attributes['password']);
            }
            return parent::update($attributes, $id);
        }
    }

    /**
     * Update Password 
     *
     * @param array $attributes
     * @param int $id - User Id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $checkEmail =  $this->model
        ->where('id', '!=',$id)
        ->where('email',$attributes['email'])
        ->get()->count();
        if($checkEmail > 0)
        {
            throw new Exception("Email already exist..!");
        }
    
        $admin = Auth::user();
        foreach($admin->roles as $item)
        {
           if($item->id == config('constant.role') )
           {
                if (isset($attributes['password'])) {
                    $attributes['password'] = Hash::make($attributes['password']);
                }
           }else
           {
                throw new Exception("Access denied");
           }
        }
        return parent::update($attributes, $id);
    }
}
