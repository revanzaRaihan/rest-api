<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total'  => 'required|numeric|min:0',
            'status' => 'nullable|string|in:pending,paid,shipped,completed',
        ];
    }
}
