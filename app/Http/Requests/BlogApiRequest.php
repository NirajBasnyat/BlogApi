<?php

namespace App\Http\Requests;

class BlogApiRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:30',
            'image' => 'image|max:2048|mimes:jpg,png,svg,webp,jpeg',
            'description' => 'required|string|min:5',
            'is_published' => 'boolean',
        ];
    }
}
