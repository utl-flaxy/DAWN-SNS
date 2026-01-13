@extends('layouts.app')

@section('title', 'ユーザープロフィール')

@section('content')
<div class="dawn-card" style="padding:18px;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px;">

        <div style="display:flex; align-items:center; gap:14px; min-width:0;">
            <img src="{{ $user->iconUrl() }}" alt="icon"
                 style="width:64px; height:64px; border-radius:9999px; object-fit:cover; border:1px solid #e2e6ee; background:#fff;">

            <div style="min-width:0;">
                <div style="font-size:18px; font-weight:700;">{{ $user->name }}</div>
                <div style="color:#666; margin-top:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $user->bio ?: '（自己紹介は未設定）' }}
                </div>
            </div>
        </div>

        <div>
            @if(!empty($isMe) && $isMe)
                <a href="{{ route('users.edit') }}"
                   class="dawn-followbtn"
                   style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">
                    プロフィール編集
                </a>
            @else
                @if(!empty($isFollowing) && $isFollowing)
                    <form method="POST" action="{{ route('follow.destroy', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="redirect" value="{{ url()->previous() }}">
                        <button type="submit" class="dawn-followbtn dawn-followbtn--danger">
                            フォローをはずす
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('follow.store', $user->id) }}">
                        @csrf
                        <input type="hidden" name="redirect" value="{{ url()->previous() }}">
                        <button type="submit" class="dawn-followbtn">
                            フォローする
                        </button>
                    </form>
                @endif
            @endif
        </div>

    </div>
</div>
@endsection
