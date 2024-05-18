<?php

namespace App\Http\Requests\Api\Dashboard\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => ['required', 'max:2000'],
            'images.*' => ['nullable', 'image'],
            'deleted_images.*' => ['nullable', 'int'],
            'image_positions.*' => ['nullable', 'int'],
            'categories.*' => ['nullable', 'int', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'published' => ['required', 'boolean']
        ];
    }
}