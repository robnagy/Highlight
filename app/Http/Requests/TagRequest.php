<?php

namespace App\Http\Requests;

use App\Services\UserService;
use App\User;
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
        // TODO: uncomment once working with authenticated users
        // return Auth::user()->id === $this->user_id;
        return true;
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
     * @param [type] $keys
     * @return void
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['user_id'] = $this->getUserId();
        return $data;
    }

    /**
     * Returns user_id based URL segment
     *
     * @return int user_id
     */
    protected function getUserId() {
        if ($this->route('user_id') === "guest") {
            $userService = new UserService(new User());
            return $userService->guestUserId();
        } else return $this->route('user_id');
    }


}
