<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Route;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // guest user allowed to modify guest tags
        if (Auth::guest() && $this->route('user_id') === "guest")
            return true;

        // logged in user allowed to modify their own tags
        if (Auth::user() && Auth::user()->id === (int) $this->route('user_id'))
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
        return [
            'text' => [
                'required',
                'max:255',
                Rule::unique('tags')->where(function ($query) {
                    return $query
                        ->where('text', $this->text)
                        ->where('user_id', $this->user_id);
                })
            ],
            'user_id' => [
                'required',
            ],
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
