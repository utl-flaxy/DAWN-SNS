@extends('layouts.app')

@section('title', 'フォローリスト')

@section('content')
@php
    $me = auth()->user();
    $followingsCount = $me->followings()->count();
    $followersCount  = $me->followers()->count();
@endphp

<div class="dawn-grid">

    {{-- 左：フォローリスト --}}
    <section class="dawn-timeline">

        {{-- タイトル --}}
        <div class="dawn-card dawn-pagecard">
            <div class="dawn-pagetitle">フォローリスト</div>
        </div>

        {{-- アイコン帯（フォロー中ユーザー） --}}
        {{-- ✅ is-spec を付けて完成形の赤枠をON --}}
        <div class="dawn-card dawn-followstrip is-spec">
            @if($followings->isEmpty())
                <div class="dawn-empty">まだ誰もフォローしていません。</div>
            @else
                <div class="dawn-followstrip__grid">
                    @foreach($followings as $u)
                        <a class="dawn-followstrip__item"
                           href="{{ route('users.show', $u->id) }}"
                           title="{{ $u->name }}">
                            <img src="{{ $u->iconUrl() }}" alt="{{ $u->name }}">
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ✅ 仕切り線（完成形の太い線） --}}
        <hr class="dawn-followdivider">

        {{-- 下：タイムライン（自分＋フォロー中の投稿） --}}
        <div class="dawn-card">
            @forelse($posts as $post)
                @php $isMePost = ((int)$post->user_id === (int)$me->id); @endphp

                <div class="dawn-post">
                    <div class="dawn-post__avatar">
                        <a href="{{ route('users.show', $post->user_id) }}" style="display:inline-flex; text-decoration:none;">
                            <img src="{{ $post->user->iconUrl() }}" alt="icon">
                        </a>
                    </div>

                    <div>
                        <div class="dawn-post__name">
                            <a href="{{ route('users.show', $post->user_id) }}" style="text-decoration:none; color:inherit;">
                                {{ $post->user->name }}
                            </a>
                        </div>

                        <div class="dawn-post__body">{{ $post->content }}</div>
                    </div>

                    <div class="dawn-post__right">
                        <div class="dawn-post__time">{{ $post->created_at->format('Y-m-d H:i') }}</div>

                        @if($isMePost)
                            <div class="dawn-post__actions">
                                <a class="dawn-iconbtn dawn-iconbtn--edit"
                                   href="{{ route('posts.edit', $post->id) }}"
                                   title="編集">
                                    <img src="{{ asset('assets/icons/pencil.png') }}" alt="edit">
                                </a>

                                <form class="dawn-inline"
                                      method="POST"
                                      action="{{ route('posts.destroy', $post->id) }}"
                                      onsubmit="return confirm('このつぶやきを削除します。よろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dawn-iconbtn dawn-iconbtn--delete" type="submit" title="削除">
                                        <img src="{{ asset('assets/icons/trash.png') }}" alt="trash">
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="dawn-empty">投稿がありません。</div>
            @endforelse
        </div>

        <div class="dawn-pager">
            {{ $posts->links() }}
        </div>
    </section>

    {{-- 右：サイドバー --}}
    <aside class="dawn-sidebar">

        <div class="dawn-sidecard">
            <div class="dawn-sidecard__title">{{ $me->name }}さんの</div>

            <div class="dawn-sidecard__row">
                <div class="dawn-sidecard__label">フォロー数</div>
                <div class="dawn-sidecard__count">{{ $followingsCount }} 名</div>
            </div>

            <a class="dawn-sidebtn" href="{{ route('follow.following') }}">フォローリスト</a>

            <div class="dawn-sidecard__row mt18">
                <div class="dawn-sidecard__label">フォロワー数</div>
                <div class="dawn-sidecard__count">{{ $followersCount }} 名</div>
            </div>

            <a class="dawn-sidebtn" href="{{ route('follow.followers') }}">フォロワーリスト</a>
        </div>

        <div class="dawn-sidecard mt12">
            <a class="dawn-sidebtn" href="{{ route('users.search') }}">ユーザー検索</a>
        </div>

    </aside>
</div>
@endsection
