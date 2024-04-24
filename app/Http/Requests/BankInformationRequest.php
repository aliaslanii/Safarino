<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankInformationRequest extends FormRequest
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
            "cardnumber" => "min:16|max:16|string",
            "shabanumber" => "min:16|max:24|string"
        ];
    }
}
