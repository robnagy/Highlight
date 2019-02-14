<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;

interface EloquentServiceInterface
{
    /**
     * Finds Model using $id
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id) : Model;

    /**
     * Creates a new Model instance using $modelAttributes values.
     * Model is saved to database and returned with ID.
     *
     * @param array $modelAttributes
     * @return Model
     */
    public function create(array $modelAttributes) : Model;

    /**
     * Creates new instance of Model, using values passed in via array.
     * Returns Model that has not been saved to the database.
     *
     * @param array $modelAttributes
     * @return Model
     */
    public function new(array $modelAttributes) : Model;

    /**
     * Updates model with given array values.
     *
     * @param Model $model
     * @param array $updatedFields
     * @return Model
     */
    public function update(Model $model, array $updatedFields) : Model;

    /**
     * Saves Model to database. Returns saved Model instance.
     *
     * @param Model $model
     * @return Model
     */
    public function save(Model $model) : Model;

    /**
     * Returns collection of all instances of Model
     *
     * @return Collection
     */
    public function all() : Collection;
}
