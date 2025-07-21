<?php

namespace App\Http\Requests\TimeCapsule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTimeCapsuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return Auth::check(); TODO: test this
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
            'reveal_date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'is_surprise_mode' => 'boolean',
            'visibility' => 'required|string|in:public,unlisted,private',
            'content_type' => 'required|string|in:text',
            'content_text' => 'required|string',
        ];
    }
}
