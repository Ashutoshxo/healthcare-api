<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone'     => ['required', 'string', 'min:3', 'unique:patients,phone'],
            'email'     => ['required', 'email', 'unique:patients,email'],
            'dob'       => ['nullable', 'date'],
        ];
    }
}
