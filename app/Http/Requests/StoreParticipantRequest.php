<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:20',
            'email' => ['required','email','max:30',
                Rule::unique('participants', 'email')->where(function ($query) {
                    return $query->where('event_id', $this->event_id);}),],
            'event_id' => 'required|exists:events,id',
            'phone' => 'required|digits_between:10,11',
            'address' => 'nullable|string|max:150',
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
            'phone.required' => 'Phone number is required.',
            'phone.digits_between' => 'Phone number must be between 10 and 11 digits.',
        ];
    }
}
