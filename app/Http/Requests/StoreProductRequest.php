<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|max:100|unique:products,sku',
            'barcode'       => 'nullable|string|max:100',
            'category_id'   => 'nullable|exists:categories,id',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|max:2048',
            'cost_price'    => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'unit'          => 'required|string|max:50',
            'current_stock' => 'required|integer|min:0',
            'min_stock'     => 'required|integer|min:0',
            'max_stock'     => 'nullable|integer|min:0',
            'warehouse'     => 'nullable|string|max:255',
            'status'        => 'required|in:active,inactive,draft,archived',
        ];
    }
}
