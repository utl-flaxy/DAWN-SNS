@extends('layouts.app')

@section('title', 'フォロワーリスト')

@section('content')
@php
    $me = auth()->user();
    $followingsCount = $me->followings()->count();
    $followersCount  = $me->followers()->count();
@endphp

<div class="dawn-grid">

    <section class="dawn-timeline">

        <div class="dawn-card dawn-pagecard">
            <div class="dawn-pagetitle">フォロワーリスト</div>
        </div>

        {{-- 上：フォロワー（アイコン帯） --}}
        <div class="dawn-card dawn-followstrip">
            @if($followers->isEmpty())
                <div class="dawn-empty">フォロワーがいません。</div>
            @else
                <div class="dawn-followstrip__grid">
                    @foreach($followers as $u)
                        <a class="dawn-followstrip__item"
                           href="{{ route('users.show', $u->id) }}"
                           title="{{ $u->name }}">
                            <img src="{{ $u->iconUrl() }}" alt="{{ $u->name }}">
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 中：フォロワー一覧（名前＋フォロー/解除） --}}
        <div class="dawn-card dawn-followlist">
            <div class="dawn-userlist">
                @forelse($followers as $u)
                    <div class="dawn-userrow">
                        <div class="dawn-userleft">
                            <a href="{{ route('users.show', $u->id) }}" style="display:inline-flex; text-decoration:none;">
                                <img class="dawn-useravatar" src="{{ $u->iconUrl() }}" alt="{{ $u->name }}">
                            </a>
                            <div class="dawn-username">{{ $u->name }}</div>
                        </div>

                        <div class="dawn-userright">
                            @if(in_array($u->id, $followingIds ?? [], true))
                                <form method="POST" action="{{ route('follow.destroy', $u->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="redirect" value="{{ url()->full() }}">
                                    <button type="submit" class="dawn-followbtn dawn-followbtn--danger">
                                        フォローをはずす
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('follow.store', $u->id) }}">
                                    @csrf
                                    <input type="hidden" name="redirect" value="{{ url()->full() }}">
                                    <button type="submit" class="dawn-followbtn">
                                        フォローする
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="dawn-empty">フォロワーがいません。</div>
                @endforelse
            </div>
        </div>

        {{-- 下：タイムライン（自分＋フォロワーの投稿） --}}
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
