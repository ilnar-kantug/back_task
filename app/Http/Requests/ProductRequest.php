<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:248',
            'description' => 'nullable|string',
            'photo' => 'required|file|image|max:3000',
            'categories' => 'nullable|array',
            'categories.*' => 'nullable|integer|exists:categories,id',
        ];
    }
}
