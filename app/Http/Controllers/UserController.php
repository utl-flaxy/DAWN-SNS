<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        // 全てログイン必須
        $this->middleware('auth');
    }

    /**
     * ユーザー検索
     * GET /users/search?q=...
     */
    public function search(Request $request)
    {
        $me = $request->user();
        $q  = trim((string) $request->query('q', ''));

        // 自分がフォローしているID一覧（Bladeで高速判定する用）
        $followingIds = $me->followings()
            ->pluck('users.id')
            ->values()
            ->all();

        $query = User::query()
            ->where('id', '!=', $me->id);

        if ($q !== '') {
            $query->where('name', 'like', "%{$q}%");
        }

        $users = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.search', compact('users', 'q', 'followingIds'));
    }

    /**
     * ユーザープロフィール（他ユーザー含む）
     * GET /users/{id}
     */
    public function show(Request $request, $id)
    {
        $me   = $request->user();
        $user = User::findOrFail($id);

        $isMe = ((int) $me->id === (int) $user->id);

        // フォロー中か（自分自身なら false 固定でOK）
        $isFollowing = false;
        if (! $isMe) {
            $isFollowing = $me->followings()
                ->where('users.id', $user->id)
                ->exists();
        }

        // カウント（プロフィール表示に使う想定）
        $followingsCount = $user->followings()->count();
        $followersCount  = $user->followers()->count();

        // そのユーザーの投稿（仕様S10の想定：プロフィール内に投稿一覧）
        $posts = Post::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        return view('users.show', compact(
            'user',
            'me',
            'isMe',
            'isFollowing',
            'followingsCount',
            'followersCount',
            'posts'
        ));
    }

    /**
     * 自分のプロフィール編集
     * GET /profile/edit
     */
    public function edit(Request $request)
    {
        $me = $request->user();
        return view('users.edit', compact('me'));
    }

    /**
     * 自分のプロフィール更新
     * POST /profile/update
     */
    public function update(Request $request)
    {
        $me = $request->user();

        // 仕様寄せ（必要ならここは緩めてもOK）
        $data = $request->validate([
            // 仕様書だと「4〜12文字」になってる
            'name' => ['required', 'string', 'min:4', 'max:12'],

            // 仕様書だと「400文字以内」
            'bio'  => ['nullable', 'string', 'max:400'],
        ]);

        $me->update($data);

        return redirect()
            ->route('users.edit')
            ->with('success', '更新しました');
    }
}
