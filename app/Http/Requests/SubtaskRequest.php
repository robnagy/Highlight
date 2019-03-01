<?php

namespace App\Http\Requests;

use App\Traits\RequestAuthorizeTrait;
use App\Traits\RouteTaskIdTrait;
use App\Traits\RouteUserIdTrait;
use Illuminate\Foundation\Http\FormRequest;

class SubtaskRequest extends FormRequest
{
    use RequestAuthorizeTrait;
    use RouteTaskIdTrait;
    use RouteUserIdTrait;

    /**
     * Determine if the user can proceed with this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->authorizeUserId() &&
            $this->authorizeUserIdTaskId($this->translateRouteUserId(),$this->task_id)) {
                return true;
            }

        return false;
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
