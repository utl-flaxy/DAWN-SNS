<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => '投稿内容を入力してください。',
            'content.max' => '投稿は255文字以内で入力してください。',
        ];
    }
}
