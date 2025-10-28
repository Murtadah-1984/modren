<?php

declare(strict_types=1);

namespace Modules\RBAC\Interface\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;

final class StorePermissionRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:permissions,name',
                'regex:/^[a-zA-Z0-9\s\-_\.]+$/',
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
            'name.required' => 'The permission name field is required.',
            'name.unique' => 'This permission name already exists.',
            'name.regex' => 'The permission name can only contain letters, numbers, spaces, hyphens, underscores, and dots.',
            'name.max' => 'The permission name must not exceed 255 characters.',
            'guard_name.max' => 'The guard name must not exceed 255 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->has('guard_name')) {
            $this->merge([
                'guard_name' => config('auth.defaults.guard'),
            ]);
        }
    }
}
