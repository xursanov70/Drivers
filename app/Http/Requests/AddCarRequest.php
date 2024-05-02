<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCarRequest extends FormRequest
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
            "car_name" => "required|max:80|min:2",
            "car_number" => "required|string|size:11|unique:cars,car_number,except,id",
        ];
    }

    public function messages()
    {
        return [
            "car_name.max" => "mashina nomi 80 ta belgidan kam bo'lishi kerak",
            "car_name.min" => "mashina nomi 2 ta belgidan kam bo'lmasligi kerak",
            "car_name.required" => "mashina nomi kiriting",

            "car_number.required" => "mashina raqami raqam kiriting",
            "car_number.unique" => "bu mashina raqam oldin kiritilgan",
            "car_number.size" => "mashina raqamni to'liq kiriting",
        ];
    }
}
