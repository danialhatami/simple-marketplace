<?php

namespace Danial\SimpleMarketplace\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SearchProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => 'nullable|string',
            'max_price' => 'sometimes|numeric',
            'sort_by_price' => 'sometimes|in:asc,desc',
            'user_id' => 'nullable|exists:users,id'
        ];
    }
}
