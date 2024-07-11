<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements IRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    // public function __construct(Model $model)
    // {
    //     $this->model = $model;
    // }

    /**
     *
     */
    public function __construct()
    {
        $this->app = app();
        $this->makeModel();
        $this->boot();
    }

    public function boot(){}

     /**
     * @throws RepositoryException
     */
    public function resetModel()
    {
        $this->makeModel();
    }

     /**
     * Returns the current Model instance
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        return $this->model = $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    /**
     * Set the model for repository.
     *
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Add orderBy.
     *
     * @param  mixed $relations
     * @return $this
     */
    public function orderBy($column, $direction = 'desc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    /**
     * Get model total.
     *
     * @return int
     */
    public function total()
    {
        return $this->model->count();
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Update or Create an entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Update or Create an entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $record = $this->model->find($id);
        $record->update($attributes);
        return $record;
    }

    /**
     * Update or Create an entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Get data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function searchByParams(array $params)
    {
        $query = $this->model;

        foreach ($params as $field => $value) {
            $query = $query->where($field, '=', $value);
        }

        return $query->get();
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null|int $limit
     * @param array $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginate($perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return mixed
     */
    public function limit($limit)
    {
        return $this->model->limit($limit)->get();
    }

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function first()
    {
        return $this->model->first();
    }

    /**
     * Get data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * Count results of repository
     *
     * @param array $where
     * @param string $columns
     *
     * @return int
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'], $relations = [])
    {
        // load realtion
        if (count($relations)) {
            $this->model->with($relations);
        }

        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();
        return $model;
    }
}
