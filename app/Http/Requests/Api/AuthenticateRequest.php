<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'telephone' => [
                'bail',
                'required',
                'numeric',
                'digits:10',
                'exists:users'
            ],
            'password' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
