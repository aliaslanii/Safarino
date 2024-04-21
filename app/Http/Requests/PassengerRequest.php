<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PassengerRequest extends FormRequest
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
            'firstName' => 'required|string|min:3|max:50',
            'lastName' => 'required|min:3|max:50',
            'birthday' => 'required|date',
            'gender' =>'required|in:femail,male',
            'nationalcode' => 'required|string|min:10|max:11'
        ];
    }
}
