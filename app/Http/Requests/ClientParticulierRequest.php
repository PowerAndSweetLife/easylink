<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientParticulierRequest extends FormRequest
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
            'email' => ['required', 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', Rule::unique('clients')->ignore($this->client)],
            'contact' => ['required'],
            'password' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'civility' => ['required'],
            'confirm-password' => ['required']
        ];
    }
}
