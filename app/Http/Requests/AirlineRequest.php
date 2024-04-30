<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirlineRequest extends FormRequest
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
            'name' => 'required|unique:airlines,name|string|min:3|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
    public function rulesUpdate(string $id): array
    {
        return [
            'name' => 'required|string|min:3|max:100|unique:airlines,name,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
