<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * 認可チェック
     */
    public function authorize(): bool
    {
        // 認証済みユーザーのみ許可
        return Auth::check();
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'name'  => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $userId],
            'bio'   => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * カスタムエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'name.required'  => 'ユーザー名は必須です。',
            'name.max'       => 'ユーザー名は50文字以内で入力してください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email'    => 'メールアドレスの形式が正しくありません。',
            'email.unique'   => 'このメールアドレスはすでに使用されています。',
            'bio.max'        => '自己紹介は255文字以内で入力してください。',
        ];
    }
}
