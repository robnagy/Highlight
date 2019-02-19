<?php

namespace App\Http\Requests;

use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // guest user allowed to modify guest tasks
        if (Auth::guest() && $this->route('user_id') === "guest")
            return true;
        // logged in user allowed to modify their own tasks
        if (Auth::user() && Auth::id() === (int) $this->route('user_id'))
            return true;

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
        $expanded = 'boolean';
        $subTasks = 'nullable|array';

        return [
            'name' => $name,
            'status' => $status,
            'expanded' => $expanded,
            'subTasks' => $subTasks,
            'subTasks.*.name' => $name,
            'subTasks.*.status' => $status,
            'subTasks.*.expanded' => $expanded,
        ];
    }

    /**
     * Adds route parameters to Request data, allowing
     * validation rules to be run against them.
     *
     * @param array $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['user_id'] = $this->getUserId();
        Log::debug('Task request data is '.json_encode($data));
        return $data;
    }

    /**
     * Retrieves the user_id parameter via UserService class
     *
     * @return int
     */
    protected function getUserId()
    {
        return UserService::getUserIdFromRoute();
    }
}
