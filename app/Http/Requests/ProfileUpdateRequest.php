<?php

namespace App\Http\Requests;

use App\Rules\PersonNameRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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
            'username' => ['required', 'lowercase', 'string', 'lowercase', 'max:32', Rule::unique('users')->ignore($this->user()->id)],
            'picture' => [
                'image',
                File::types(['jpeg', 'jpg', 'png'])->max('5mb'),
                'dimensions:min_width =250,min_height =175,max_width =500,max_height =350'],
        ];
    }
}
