<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\PersonNameRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:16', new PersonNameRules],
            'last_name' => ['required', 'max:16', new PersonNameRules],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user()->id), 'max:64'],
            'password' => ['required', 'max:32'],
            'bio' => ['nullable', 'max:128'],
            'username' => ['required', 'lowercase', 'string', 'lowercase','max:32',Rule::unique('users')->ignore($this->user()->id)],
        ];
    }
}
