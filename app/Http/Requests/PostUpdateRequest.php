<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // ログイン済みならOK
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'post' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'post.required' => '投稿内容を入力してください。',
            'post.max' => '投稿内容は255文字以内で入力してください。',
        ];
    }
}
