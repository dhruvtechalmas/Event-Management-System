<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $participant = $this->route('participant');

        return [
            'full_name' => 'required|string|max:255',
            'email' => ['required','email','max:255',
                Rule::unique('participants', 'email')->ignore($participant),
            ],
            'event_id' => 'required|exists:events,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'event_id.required' => 'Please select an event.',
            'event_id.exists' => 'Selected event does not exist.',
        ];
    }
}
