<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class PostFeedRequest extends FormRequest
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
            'description' => ['required', 'max:4096'],
            'picture' => [
                'image',
                File::types(['jpeg', 'jpg', 'png'])->max('5mb'),
                'dimensions:min_width =250,min_height =175,max_width =1000,max_height =700'],
        ];
    }
}
