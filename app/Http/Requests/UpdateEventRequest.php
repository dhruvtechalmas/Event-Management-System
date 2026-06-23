<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->filled('event_time')) {
            $time = $this->event_time;

            // If time is HH:MM, convert to HH:MM:SS
            if (substr_count($time, ':') === 1) {
                $time .= ':00';
            }

            $this->merge([
                'event_time' => $time,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'event_name' => 'required|string|max:255',
            'event_type' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i:s',
            'event_location' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:Draft,Upcoming,Ongoing,Completed,Cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'event_name.required' => 'Event name is required.',
            'event_date.required' => 'Event date is required.',
            'event_time.date_format' => 'Event time must be in HH:MM:SS format.',
            'capacity.required' => 'Event capacity is required.',
            'capacity.integer' => 'Capacity must be a number.',
            'capacity.min' => 'Capacity must be at least 1.',
            'status.in' => 'Invalid status selected.',
        ];
    }
}