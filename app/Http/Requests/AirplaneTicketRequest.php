<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirplaneTicketRequest extends FormRequest
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
            'adultPrice' => 'required|integer',
            'arrivalTime' => 'required|string',
            'departureTime' => 'required|string',
            'capacity' => 'required|integer',
            'aircraft' => 'required|string',
            'maxAllowedBaggage' => 'required|integer',
            'flightNumber' => 'required|string',
            'airline_id' => 'required',
            'airport_id' => 'required',
            'origin' => 'required|integer',
            'destination' => 'required|integer',
            'type' => 'required|in:Charter,Systemic',
            'cabinclass' => 'required|in:Economy,Business,Firstclass',
        ];
    }
}
