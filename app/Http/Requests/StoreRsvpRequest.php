<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRsvpRequest extends FormRequest
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
            'name'       => 'required|string|unique:rsvps,name',
            'attendence' => 'required|boolean',
            'no_of_pax'  => 'nullable|integer',
            'notes'      => 'required|string|max:500',
            'event_id'   => 'required|exists:events,id',
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'       => 'Please enter your name.',
            'name.unique'         => 'This name has already been registered.',
            'attendence.required' => 'Please specify your attendance.',
            'notes.required'      => 'Please provide some wishes.',
        ];
    }
}
