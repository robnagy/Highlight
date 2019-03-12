<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    use \App\Traits\RouteTaskIdTrait;
    use \App\Traits\RouteUserIdTrait;

    /**
     * Determine if the user can proceed with this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = $this->route('user_id');

        if ($task_id = $this->input('id'))
        {
            return $this->user()->can('update', [Task::class, $user_id, $task_id]);
        }

        return $this->user()->can('create', [Task::class, $user_id]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $name = 'required|string|max:255';
        $status = 'required|string|max:255|in:new,completed,editing,selected';
        $expanded = 'boolean';
        $user_id = 'exists:users,id';

        return [
            'name' => $name,
            'status' => $status,
            'expanded' => $expanded,
            'user_id' => $user_id,
        ];
    }

    /**
     * Adjusts the request data object provided for validation.
     * Allows for injecting or modifying of values,
     * e.g. to insert route parameters.
     *
     * @param array $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['user_id'] = $this->translateRouteUserId();
        $data['task_id'] = $this->getTaskIdFromRoute();
        return $data;
    }
}
