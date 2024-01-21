<?php

namespace Danial\SimpleMarketplace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'string|required|min:5|max:150',
            'price' => 'numeric|required|min:1',
            'delivery_price' => 'sometimes|numeric',
            'images' => 'array|required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
