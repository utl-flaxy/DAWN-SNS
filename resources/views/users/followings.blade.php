@extends('layouts.app')

@section('content')
<div class="container" style="display:flex; gap:24px;">
  <div style="flex:1;">
    <h2 style="margin:0 0 14px;">Follow list</h2>

    <div style="background:#fff; border:1px solid #ddd; padding:18px;">
      <div style="display:flex; flex-wrap:wrap; gap:10px; padding:10px; border:1px solid #caa;">
        @forelse($users as $u)
          <a href="#" title="{{ $u->name }}"
             style="display:block; width:44px; height:44px; border-radius:999px; background:#e9eef7;"></a>
        @empty
          <div style="color:#777;">まだフォローしているユーザーはいません。</div>
        @endforelse
      </div>
    </div>
  </div>

  <div style="width:320px;">
    <div style="background:#fff; border:1px solid #ddd; padding:18px;">
      <a href="{{ route('users.followings') }}" style="display:block; margin-bottom:10px; text-align:center; padding:10px; background:#2f3b55; color:#fff; text-decoration:none;">フォローリスト</a>
      <a href="{{ route('users.followers') }}" style="display:block; margin-bottom:10px; text-align:center; padding:10px; background:#2f3b55; color:#fff; text-decoration:none;">フォロワーリスト</a>
      <a href="{{ route('users.search') }}" style="display:block; text-align:center; padding:10px; background:#2f3b55; color:#fff; text-decoration:none;">ユーザー検索</a>
    </div>
  </div>
</div>
@endsection
