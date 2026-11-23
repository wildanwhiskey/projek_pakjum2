<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role->name === 'user';
    }

    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'umur'   => 'required|integer|min:0|max:120',
            'alamat' => 'required|string|max:500',
            'bio'    => 'required|string|max:1000',
        ];
    }
}