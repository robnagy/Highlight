<?php

namespace App\Services;

use App\Interfaces\EloquentServiceInterface;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class EloquentService implements EloquentServiceInterface
{
    /**
     * Eloquent model for use in functions
     *
     * @var Illuminate\Database\Eloquent\Model
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

    public function find(int $id) : Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $modelAttributes) : Model
    {
        return $this->model->create($modelAttributes);
    }

    public function createFromRequest(FormRequest $request) : Model
    {
        $itemArray = $request->only($this->model->getFillable());
        return $this->create($itemArray);
    }

    public function updateFromRequest(int $resource_id, FormRequest $request) : array
    {
        $model = $this->model->find($resource_id);
        $itemArray = $request->only($this->model->getFillable());
        $model->update($itemArray);
        $model->save();
        return $model->toArray();
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

    public function allForUser(int $user_id) : Collection
    {
        return $this->model->where('user_id', $user_id)->get();
    }

    public function allForUserWith(int $user_id, array $with) : Collection
    {
        return $this->model->with($with)->where('user_id', $user_id)->get();
    }

    public function allForUserWithCount(int $user_id, array $countThese) : Collection
    {
        return $this->model->withCount($countThese)->where('user_id', $user_id)->get();
    }

    public function where(string $column, $value) : Collection
    {
        return $this->model->where($column, $value)->get();
    }

    public function whereWith(array $where, array $with) : Collection
    {
        $query = $this->model;
        foreach ($where as $w) {
            if (count($w) === 3)
                $query = $query->where($w[0], $w[2], $w[1]);
            else
                $query = $query->where($w[0], $w[1]);
        }
        return $query->with($with)->get();
    }

    public function selectWhere(array $columns, array $values) : Collection
    {
        return $this->model->where($values)->select($columns)->get();
    }

    public function pluckFirstWhere(string $pluck, array $where)
    {
        return $this->model->where($where)->pluck($pluck)->first();
    }

    public function bulkDelete(array $ids)
    {
        return $this->model->destroy($ids);
    }
}
