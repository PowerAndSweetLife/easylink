<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminReqest extends FormRequest
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
            "username" => ["required", Rule::unique('admins')->ignore($this->admin)],
            "firstname" => "required",
            "lastname" => "required",
            "email" => ["required", 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', Rule::unique('admins')->ignore($this->admin)],
            "contact" => "required"
        ];
    }
}