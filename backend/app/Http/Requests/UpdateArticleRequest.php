<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'title' => ['string', 'max:255'],
            'content' => ['string'],
            'categories_id' => ['present', 'array'],
            'categories_id.*' => ['integer', 'exists:categories,id'],
            'image' => ['nullable', 'image']
        ];
    }
}
