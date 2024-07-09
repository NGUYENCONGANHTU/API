<?php

namespace App\Repositories;
use App\Repositories\BaseRepository;
use App\Models\Role;

class RoleRepository extends BaseRepository
{

     /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
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
        $limit = $this->limit(config('constant.defaultLimit'));

        $query = $this->model->query();

        if (isset($params['name'])) {
           $query->where('title','like','%'.$params['name'].'%');
        }

        if(isset($params['status'])) {
           $query->where('status','=', (int) $params['status']);
        }

        return $query->paginate($limit);
    }
    
    /**
     * Create a new role
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

     /**
     * Update a role by id
     *
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $role = $this->model->findOrFail($id);
        $role->update($attributes);
        return $role;
    }

}