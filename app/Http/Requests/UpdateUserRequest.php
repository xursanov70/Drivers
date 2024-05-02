<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "full_name" => "required|max:50|min:2",
        ];
    }

    public function messages()
    {
        return [
            "full_name.max" => "full_name 50 ta belgidan kam bo'lishi kerak",
            "full_name.min" => "full_name 2 ta belgidan kam bo'lmasligi kerak",
            "full_name.required" => "to'liq ismingizni kiriting",
        ];
    }
}
