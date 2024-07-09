<?php

/**
 * Base code api laravel framework
 * Copyright © 2024
 * @***CVD***@
 */

namespace App\Repositories;

interface IRepository
{

    public function boot();
    
    /**
     * Returns the current Model instance
     *
     * @return Model
     */
    public function getModel();

    /**
     * @throws RepositoryException
     */
    public function resetModel();
    
    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel();

    /**
     * Add orderBy.
     *
     * @param  mixed $relations
     * default asc
     * @return $this
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * Get model total.
     *
     * @return int
     */
    public function total();

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id);

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
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Update a entity in repository by id
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id);

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
    public function create(array $attributes);

    /**
     * Get data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function searchByParams(array $params);

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null|int $limit
     * @param array $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginate($perPage = 10);

    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return mixed
     */
    public function limit($limit);

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function first();

    /**
     * Get data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function get();

    /**
     * Count results of repository
     *
     * @param array $where
     * @param string $columns
     *
     * @return int
     */
    public function count();

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all();

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*']);
}
