<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKritikRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya user biasa yang boleh berkomentar (admin tidak boleh)
        return $this->user() && $this->user()->role->name === 'user';
    }

    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:1000',
            'rating'  => 'required|integer|min:1|max:5',
        ];
    }
}   