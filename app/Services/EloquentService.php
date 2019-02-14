<?php

namespace App\Services;

use App\Interfaces\EloquentServiceInterface;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;

class EloquentService implements EloquentServiceInterface
{
    /**
     * Eloquent model for use in functions
     *
     * @var model
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

    /**
    * {@inheritdoc}
    */
    public function find(int $id) : Model {
        return $this->model->findOrFail($id);
    }

    /**
    * {@inheritdoc}
    */
    public function create(array $modelAttributes) : Model {
        return $this->model->create($modelAttributes);
    }

    /**
    * {@inheritdoc}
    */
    public function new(array $modelAttributes) : Model {
        return new $this->model($modelAttributes);
    }

    /**
    * {@inheritdoc}
    */
    public function update(Model $model, array $updatedFields) : Model {
        $model->update($updatedFields);
        return $model;
    }

    /**
    * {@inheritdoc}
    */
    public function save(Model $model) : Model {
        $model->save();
        return $model;
    }

    /**
    * {@inheritdoc}
    */
    public function all() : Collection {
        return $this->model->all();
    }

}
