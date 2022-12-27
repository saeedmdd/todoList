<?php

namespace App\Http\Requests\Api\v1\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "required|string|between:2,255",
            "email" => "required|email|unique:users,email|max:255",
            "password" => "required|confirmed|max:255"
        ];
    }
}
