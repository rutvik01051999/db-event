<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'event_title' => 'required',
            'event_start' => 'required|date_format:Y-m-d',
            'event_end' => 'required|date_format:Y-m-d|after:event_start',
            "quation"    => "required|array",
            "quation.*"  => "required|string",
            "option"    => "required|array",
            "option.*"  => "required|string",
            "option_type"    => "required|array",
            "option_type.*"  => "required|string",
            "required"    => "required|array",
            "required.*"  => "required|string",    
            "logo"=> "required|image|mimes:jpeg,png,gif|max:2048"        
        ];
    }
}
