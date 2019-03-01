<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Services\UserService;
use App\Traits\RequestAuthorizeTrait;
use App\Traits\RouteUserIdTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Route;

class TagRequest extends FormRequest
{
    use RequestAuthorizeTrait;
    use RouteUserIdTrait;

    /**
     * Determine if the user can proceed with this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->authorizeUserId())
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
                }),
            ],
            'user_id' => 'exists:users,id',
        ];
    }

}
