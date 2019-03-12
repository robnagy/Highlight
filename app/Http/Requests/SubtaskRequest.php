<?php

namespace App\Http\Requests;

use App\Models\Subtask;
use App\Traits\RouteTaskIdTrait;
use App\Traits\RouteUserIdTrait;
use Illuminate\Foundation\Http\FormRequest;

class SubtaskRequest extends FormRequest
{
    use RouteTaskIdTrait;
    use RouteUserIdTrait;

    /**
     * Determine if the user can proceed with this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = $this->route('user_id');
        $task_id = $this->route('task_id');

        if ($subtask_id = $this->input('id'))
        {
            return $this->user()->can('update', [Subtask::class, $task_id, $subtask_id]);
        }

        return $this->user()->can('create', [Subtask::class, $user_id, $task_id]);
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

        return [
            'name' => $name,
            'status' => $status,
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'exists:users,id',
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
