<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct()
    {
        // フォロー系はログイン必須
        $this->middleware('auth');
    }

    /**
     * フォローリスト（フォロー中ユーザー + タイムライン）
     * GET /follow/following
     */
    public function following(Request $request)
    {
        $me = $request->user();

        // フォロー中ユーザー一覧（アイコン帯）
        $followings = $me->followings()
            ->select('users.*')
            ->orderBy('users.name')
            ->get();

        // 自分 + フォロー中ユーザーの投稿（タイムライン）
        $ids = $followings->pluck('id')->push($me->id)->unique()->values();

        $posts = Post::with('user')
            ->whereIn('user_id', $ids)
            ->latest()
            ->paginate(20);

        return view('follow.following', compact('followings', 'posts'));
    }

    /**
     * フォロワーリスト（フォロワー + タイムライン）
     * GET /follow/followers
     */
    public function followers(Request $request)
    {
        $me = $request->user();

        // フォロワー一覧（アイコン帯/一覧で使う）
        $followers = $me->followers()
            ->select('users.*')
            ->orderBy('users.name')
            ->get();

        // 自分がフォローしてるID（フォロワー一覧のボタン判定用）
        $followingIds = $me->followings()
            ->pluck('users.id')
            ->values()
            ->all();

        // 自分 + フォロワーの投稿（タイムライン）
        $ids = $followers->pluck('id')->push($me->id)->unique()->values();

        $posts = Post::with('user')
            ->whereIn('user_id', $ids)
            ->latest()
            ->paginate(20);

        return view('follow.followers', compact('followers', 'followingIds', 'posts'));
    }

    /**
     * フォローする
     * POST /follow/{user_id}
     */
    public function store(Request $request, $user_id)
    {
        $me = $request->user();
        $targetId = (int) $user_id;

        // redirect（無ければ直前のURL）
        $redirect = $request->input('redirect', url()->previous());

        // 自分はフォローできない
        if ($targetId === (int) $me->id) {
            return redirect($redirect);
        }

        // 存在チェック（変なIDが来ても落とさない）
        $exists = User::whereKey($targetId)->exists();
        if (! $exists) {
            return redirect($redirect)->with('error', 'ユーザーが見つかりませんでした');
        }

        // 既にフォローしてなければ追加（重複しない）
        $me->followings()->syncWithoutDetaching([$targetId]);

        return redirect($redirect)->with('success', 'フォローしました');
    }

    /**
     * フォローを外す
     * DELETE /follow/{user_id}
     */
    public function destroy(Request $request, $user_id)
    {
        $me = $request->user();
        $targetId = (int) $user_id;

        $redirect = $request->input('redirect', url()->previous());

        // 自分を外す、みたいな変な操作は無視
        if ($targetId === (int) $me->id) {
            return redirect($redirect);
        }

        $me->followings()->detach($targetId);

        return redirect($redirect)->with('success', 'フォローを外しました');
    }
}
