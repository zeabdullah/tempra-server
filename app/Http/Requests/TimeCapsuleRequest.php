<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeCapsuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Insert auth logic here...
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('GET')) {
            return [
                'title' => 'string|nullable|max:255',
            ];
        }

        if ($this->isMethod('POST')) {
            return [
                'title' => 'string|max:255',
                'color' => 'string|max:50',
                'reveal_date' => 'required|date|after:now',
                'location' => 'required|string|max:255',
                'is_surprise_mode' => 'boolean',
                'visibility' => 'required|string|in:public,unlisted,private',
                'content_type' => 'required|string|in:text',
                'content_text' => 'required|string',
            ];
        }

        if ($this->isMethod('PATCH')) {
            return [
                'title' => 'string|max:255',
                'color' => 'string|max:50',
                'reveal_date' => 'date|after:now',
                'location' => 'string|max:255',
                'visibility' => 'string|in:public,unlisted,private',
                'content_type' => 'string|in:text',
                'content_text' => 'string',
            ];
        }

        return [];
    }
}
