<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:255', 'string'],
            'price' => ['required', 'integer'],
            'description' => ['required', 'max:255', 'string'],
            'image' => ['required', 'image', 'dimensions:min_width=400,min_height=400'],
        ];
    }
}
