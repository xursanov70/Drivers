<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddWalletRequest extends FormRequest
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
            "expire_date" => "required|size:5",
            "code" => "required|string|size:19|unique:wallets,code,except,id",
        ];
    }

    public function messages()
    {
        return [
            "expire_date.size" => "amal qilish muddati to;liq kiriting",
            "expire_date.required" => "amal qilish muddati  kiriting",

            "code.required" => "karta raqami raqam kiriting",
            "code.unique" => "bu karta raqam oldin kiritilgan",
            "code.size" => "karta raqamni to'liq kiriting",
        ];
    }
}
