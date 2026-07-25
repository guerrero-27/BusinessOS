<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('category')?->id;

        return [
            'name'        => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $id = $this->route('category')?->id;
        session()->flash('edit_category_id', $id);

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
