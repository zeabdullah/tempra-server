<?php

namespace App\Http\Requests\TimeCapsule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeCapsuleRequest extends FormRequest
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
}
