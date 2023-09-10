<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string|mixed>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                File::types(['png', 'jpg'])
                    ->max(5 * 1024),
            ],
        ];
    }
}
