<?php

namespace App\Http\Requests\Api\v1\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "title" => "required|string|between:2,255",
            "description" => "required|string|max:1000",
            "color" => "regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i",
            "starts_at" => "required|date_format:Y-m-d H:i:s"
        ];
    }
}
