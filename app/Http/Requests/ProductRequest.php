<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        if($this->method() == 'PUT')
        {

            return [
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
                'title' => 'required|string',
                'cat_id' => 'required',
                'price' => 'required|numeric',
                'description' => 'required|string',
            ];
            
        }
        else
        {

            return [
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
                'title' => 'required|string',
                'cat_id' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'description' => 'required|string',
            ];

        }

    }

    public function messages()
    {
        return [
            'cat_id.required' => 'The category field is required.',
        ];
    }
}