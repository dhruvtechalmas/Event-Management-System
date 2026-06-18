<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
            'comment' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required.',
            'event_id.required' => 'Please select an event.',
            'event_id.exists' => 'Selected event does not exist.',
            'assigned_to.exists' => 'Selected user does not exist.',
            'due_date.required' => 'Due date is required.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid task status selected.',
        ];
    }
}
