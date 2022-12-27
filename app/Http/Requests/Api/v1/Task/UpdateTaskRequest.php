<?php

namespace App\Http\Requests\Api\v1\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            "title" => "required|string|between:2,255",
            "description" => "required|string|max:1000",
            "color" => "regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i",
            "starts_at" => "required|date_format:Y-m-d H:i:s"
        ];
    }
}
