<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $users = User::query()
            ->where('id', '!=', $request->user()->id)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->limit(50)
            ->get();

        // 画面で isFollowing を高速化したいので、フォロー中IDをまとめて渡す
        $followingIds = $request->user()
            ->followings()
            ->pluck('users.id')
            ->all();

        return view('users.search', compact('users', 'q', 'followingIds'));
    }
}
