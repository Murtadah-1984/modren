<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $roleId = $this->route('id') ?? $this->route('role');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($roleId),
                'regex:/^[a-zA-Z0-9\s\-_]+$/'
            ],
            'guard_name' => ['sometimes', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The role name field is required.',
            'name.unique' => 'This role name already exists.',
            'name.regex' => 'The role name can only contain letters, numbers, spaces, hyphens, and underscores.',
            'name.max' => 'The role name must not exceed 255 characters.',
            'guard_name.max' => 'The guard name must not exceed 255 characters.',
        ];
    }
}
