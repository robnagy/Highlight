<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

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
     * Creates a new Model using mass fillable
     * values from validated Request.
     *
     * @param FormRequest $request
     * @return Model
     */
    public function createFromRequest(FormRequest $request) : Model;


    /**
     * Updates a Model using mass fillable
     * values from validated Request
     *
     * @param Model $model
     * @param FormRequest $request
     * @return Model
     */
    public function updateFromRequest(Model $model, FormRequest $request) : Model;

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

    /**
     * Returns all instances of model belonging to
     * user specified in {user_id} route segment
     *
     * @return Collection
     */
    public function allForUser($user_id) : Collection;

    /**
     * Returns all instances of model belonging to user specified
     * in {user_id} route segment, along with eager loaded
     * relationships specified in the $with array.
     *
     * @return void
     */
    public function allForUserWith(int $user_id, array $with) : Collection;

    /**
     * Returns all instances of model where a $column matches a $value
     *
     * @param string $column
     * @param integer $value
     * @return Collection
     */
    public function where(string $column, int $value) : Collection;
}
