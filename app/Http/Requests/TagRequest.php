<?php

namespace App\Http\Requests;

use App\Models\Tag;
use App\Traits\RouteUserIdTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user can proceed with this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = $this->route('user_id');

        if ($tag_id = $this->input('id'))
        {
            return $this->user()->can('update', [Tag::class, $user_id, $tag_id]);
        }
        return $this->user()->can('create', [Tag::class, $user_id]);
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
            'user_id' => 'required|exists:users,id',
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
        $data['user_id'] = $this->route('user_id');
        return $data;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'text.unique' => 'Tag already exists',
        ];
    }
}
