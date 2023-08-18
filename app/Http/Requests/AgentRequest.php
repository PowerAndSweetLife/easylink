<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "username" => ["required", Rule::unique('agents')->ignore($this->agent)],
            "firstname" => "required",
            "lastname" => "required",
            "email" => ["required", 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', Rule::unique('agents')->ignore($this->agent)],
            "contact" => "required",
            "localization_id" => "required",
            "address-small" => ["required"],
            "address-regular" => ["required"],
            "phone" => ["required"]
        ];
    }
}
