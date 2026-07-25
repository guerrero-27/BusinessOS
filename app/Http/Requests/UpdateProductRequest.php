<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $productId = $this->route('product') instanceof \App\Models\Product
            ? $this->route('product')->id
            : $this->route('product');

        return [
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|max:100|unique:products,sku,' . $productId,
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

    protected function failedValidation(Validator $validator)
    {
        $product = $this->route('product');
        $id = $product instanceof \App\Models\Product ? $product->id : $product;
        session()->flash('edit_product_id', $id);

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
