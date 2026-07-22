<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('customer')->id;

        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:customers,email,' . $customerId,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:500',
            'birth_date' => 'nullable|date|before:today',
            'gender'     => 'nullable|in:male,female,other',
            'is_active'  => 'boolean',
        ];
    }
}