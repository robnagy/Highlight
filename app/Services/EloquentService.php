<?php

namespace App\Services;

use App\Interfaces\EloquentServiceInterface;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EloquentService implements EloquentServiceInterface
{
    /**
     * Eloquent model for use in functions
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor to bind Model to service
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find(int $id) : Model {
        return $this->model->findOrFail($id);
    }

    public function create(array $modelAttributes) : Model {
        return $this->model->create($modelAttributes);
    }

    public function new(array $modelAttributes) : Model {
        return new $this->model($modelAttributes);
    }

    public function update(Model $model, array $updatedFields) : Model {
        $model->update($updatedFields);
        $model->save();
        return $model;
    }

    public function save(Model $model) : Model {
        $model->save();
        return $model;
    }

    public function all() : Collection {
        return $this->model->all();
    }

    public function allForUser($user_id) : Collection
    {
        return $this->model->where('user_id', $user_id)->get();
    }

    public function allForUserWith(int $user_id, array $with) : Collection
    {
        return $this->model->with($with)->where('user_id', $user_id)->get();
    }

}
