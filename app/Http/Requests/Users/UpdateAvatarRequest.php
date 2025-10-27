<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Add your authorization logic here
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'avatar' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,gif,webp',
                'max:2048', // 2MB max
                'dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'avatar.required' => 'Please upload an avatar image.',
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, jpg, png, gif, webp.',
            'avatar.max' => 'The avatar size must not exceed 2MB.',
            'avatar.dimensions' => 'The avatar dimensions must be between 100x100 and 4000x4000 pixels.',
        ];
    }
}
