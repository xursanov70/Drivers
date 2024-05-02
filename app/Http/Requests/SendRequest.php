<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendRequest extends FormRequest
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
            "lat" => "required|string",
            "lang" => "required|string",
        ];
    }

    public function messages()
    {
        return [
            "lat.required" => "Latitude nomi kiriting",
            "lat.required" => "Latitude string holatida kiriting",

            "lang.required" => "Longitude nomi kiriting",
            "lang.required" => "Longitude string holatida kiriting",
        ];
    }
}
