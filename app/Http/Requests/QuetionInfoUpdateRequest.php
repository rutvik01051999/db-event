<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuetionInfoUpdateRequest extends FormRequest
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
            "quation"    => "required|array",
            "quation.*"  => "required|string",
            // "option"    => "required|array",
            // "option.*"  => "required|string",
            "option_type"    => "required|array",
            "option_type.*"  => "required|string",
            "required"    => "required|array",
            "required.*"  => "required|string",    

            "p_quation"    => "required|array",
            "p_quation.*"  => "required|string",
            // "p_option"    => "required|array",
            // "p_option.*"  => "required|string",
            "p_option_type"    => "required|array",
            "p_option_type.*"  => "required|string",
            "p_required"    => "required|array",
            "p_required.*"  => "required|string",
        ];
    }
}
