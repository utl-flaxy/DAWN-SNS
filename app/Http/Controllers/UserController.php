<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * ユーザープロフィール表示
     * route('users.show', $id)
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * プロフィール編集画面
     * route('users.edit')
     */
    public function edit()
    {
        $user = auth()->user();

        // edit.blade.php は $user を参照してるので必ず渡す
        return view('users.edit', compact('user'));
    }

    /**
     * プロフィール更新
     * route('users.update')
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            // 入力された時だけ変更
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],

            'bio'  => ['nullable', 'string', 'max:500'],

            // edit.blade.php の <input name="icon">
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // 画像アップロード（iconUrl() が icon_path を見てる想定）
        if ($request->hasFile('icon')) {
            // 以前のアイコンがあれば消す（任意）
            if (!empty($user->icon_path) && Storage::disk('public')->exists($user->icon_path)) {
                Storage::disk('public')->delete($user->icon_path);
            }

            $path = $request->file('icon')->store('icons', 'public');
            $validated['icon_path'] = $path;
        }

        // password は空なら更新しない
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // icon 自体はDBに入れない（icon_path に変換したので消す）
        unset($validated['icon']);

        $user->update($validated);

        return redirect()
            ->route('users.show', $user->id)
            ->with('success', 'プロフィールを更新しました');
    }
}
