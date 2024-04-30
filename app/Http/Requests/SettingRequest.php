<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_phone" => "string|min:3|max:255",
            "second_phone" => "string|min:3|max:255",
            "email" => "email",
            "address" => "string|min:5|max:600",
            "instagram" => "string|min:5|max:100",
            "whatsapp" => "string|min:5|max:100",
            "linkdin" => "string|min:5|max:100",
            "facebook" => "string|min:5|max:100",
        ];
    }
}
