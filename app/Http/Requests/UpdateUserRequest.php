<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255',
                Rule::unique('users', 'email')->ignore($user),
            ],
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email already exists.',
            'phone.required' => 'Phone number is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'role_id.required' => 'Please select a role.',
            'role_id.exists' => 'Selected role does not exist.',
        ];
    }
}
