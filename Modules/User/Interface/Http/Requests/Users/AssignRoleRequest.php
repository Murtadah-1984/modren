<?php

declare(strict_types=1);

namespace Modules\User\Interface\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

final class AssignRoleRequest extends FormRequest
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
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['required', 'string', 'exists:roles,name'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'roles.required' => 'Please provide at least one role.',
            'roles.array' => 'Roles must be provided as an array.',
            'roles.min' => 'Please provide at least one role.',
            'roles.*.required' => 'Each role is required.',
            'roles.*.exists' => 'One or more selected roles are invalid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'roles.*' => 'role',
        ];
    }
}
