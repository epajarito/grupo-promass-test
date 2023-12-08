<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'email' => [
                'email',
                'max:60',
                Rule::requiredIf(function () {
                    return $this->routeIs('api.users.store');
                }),
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
            'telephone' => [
                'numeric',
                'digits:10',
                Rule::unique('users', 'telephone')->ignore($this->route('user')),
                Rule::requiredIf(function () {
                    return $this->routeIs('api.users.store');
                }),
            ],
            'role' => [
                Rule::requiredIf(function () {
                    return $this->routeIs('api.users.store');
                }),
            ],
            'password' => [
                'min:8',
                Rule::requiredIf(function () {
                    return $this->routeIs('api.users.store');
                }),
            ],
            'avatar' => ['nullable', 'image', 'max:1024'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
