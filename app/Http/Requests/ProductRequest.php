<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.5',
        ];

        if ($this->isMethod('post')) {
            // Validation rules for creating a product
            $rules['image'] = 'required|image|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Validation rules for updating a product
            $rules['image'] = 'nullable|image|max:2048';
        }

        return $rules;
    }
}
