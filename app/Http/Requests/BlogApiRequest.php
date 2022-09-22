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
        $rules = [
            'title' => 'required|string|max:30',
            'image' => 'required|file|max:2048|mimes:jpg,png,svg,webp,jpeg',
            'description' => 'required|string|min:5',
            'is_published' => 'boolean',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['image'] = 'file|max:2048|mimes:jpg,png,svg,webp,jpeg';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'image.required' => "You must use the 'Choose file' button to select which file you wish to upload",
            'image.max' => "Maximum file size to upload is 2MB (2048 KB). If you are uploading a photo, try to reduce its resolution to make it under 2MB"
        ];
    }
}
