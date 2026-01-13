<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowListController extends Controller
{
    public function followings(Request $request)
    {
        $users = $request->user()
            ->followings()
            ->orderBy('name')
            ->get();

        return view('users.followings', compact('users'));
    }

    public function followers(Request $request)
    {
        $users = $request->user()
            ->followers()
            ->orderBy('name')
            ->get();

        return view('users.followers', compact('users'));
    }
}
