<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'requester_name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure' => 'required|date|date_format:Y-m-d',            
            'arrival' => 'required|date|date_format:Y-m-d|after_or_equal:departure',
            'departure' => 'required|date',
            'status' => 'required|exists:status,id'
         ];
    }


}
