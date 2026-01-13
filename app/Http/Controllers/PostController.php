<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $me = auth()->user();

        // 自分 + フォロー中ユーザーのID
        $ids = $me->followings()->pluck('users.id')->push($me->id)->unique()->values();

        $posts = Post::with('user')
            ->whereIn('user_id', $ids)
            ->latest()
            ->paginate(20);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return redirect()->route('posts.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'content' => $data['content'],
        ]);

        return redirect()->route('posts.index')->with('success', '投稿しました');
    }

    public function edit(Post $post)
    {
        abort_unless($post->user_id === auth()->id(), 403);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        abort_unless($post->user_id === auth()->id(), 403);

        $data = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $post->update([
            'content' => $data['content'],
        ]);

        return redirect()->route('posts.index')->with('success', '更新しました');
    }

    public function destroy(Post $post)
    {
        abort_unless($post->user_id === auth()->id(), 403);
        $post->delete();

        return redirect()->route('posts.index')->with('success', '削除しました');
    }
}
