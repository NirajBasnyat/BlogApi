<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentApiRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:255|string',
            'body' => 'required|min:10|string'
        ];
    }
}
