<?php

namespace App\Http\Requests;

use App\Rules\PersonNameRules;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            "first_name" => ['required', 'max:16', new PersonNameRules],
            "last_name" => ['required', 'max:16', new PersonNameRules],
            "email" => ['required', 'email', 'unique:users', 'max:64'],
            "password" => ['required', 'max:32'],
        ];
    }
}
