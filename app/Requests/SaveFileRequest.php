<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

//todo implement opml file check and validation

class SaveFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required',
            'user' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
                'file' => 'Please select a file to upload.',
          ];
    }
}
