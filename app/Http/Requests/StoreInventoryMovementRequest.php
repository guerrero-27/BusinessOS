<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryMovementRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:in,out,adjustment',
            'quantity'   => 'required|integer|min:1',
            'reason'     => 'nullable|string|max:255',
            'reference'  => 'nullable|string|max:255',
        ];
    }
}
