<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 認証済ユーザーのみ
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id', 'different:auth_id'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'フォロー対象ユーザーが指定されていません。',
            'user_id.exists' => '指定されたユーザーが存在しません。',
            'user_id.different' => '自分自身はフォローできません。',
        ];
    }

    protected function prepareForValidation()
    {
        // 現在のログインユーザーIDを追加（自分自身との比較用）
        $this->merge(['auth_id' => auth()->id()]);
    }
}
