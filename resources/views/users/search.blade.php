@extends('layouts.app')

@section('title', 'ユーザー検索')

@section('content')
@php
    $me = auth()->user();
    $followingsCount = $me->followings()->count();
    $followersCount  = $me->followers()->count();
@endphp

<div class="dawn-grid">

    {{-- 左：ユーザー検索 --}}
    <section class="dawn-timeline">

        <div class="dawn-card dawn-search-card">

            {{-- 検索バー --}}
            <form
                method="GET"
                action="{{ route('users.search') }}"
                class="dawn-searchbar {{ !empty($q) ? 'dawn-searchbar--hasword' : '' }}"
            >
                <input
                    class="dawn-searchinput"
                    type="text"
                    name="q"
                    value="{{ $q ?? '' }}"
                    placeholder="ユーザー名"
                    autocomplete="off"
                />

                @if(!empty($q))
                    <div class="dawn-searchword">
                        検索ワード：<strong>{{ $q }}</strong>
                    </div>
                @endif

                <button class="dawn-searchbtn" type="submit" title="検索" aria-label="検索">
                    {{-- outline の虫眼鏡（見本っぽい） --}}
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="2"></circle>
                        <path d="M20 20l-3.5-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </button>
            </form>

            {{-- ユーザー一覧 --}}
            <div class="dawn-userlist">
                @forelse($users as $user)
                    <div class="dawn-userrow">
                        <div class="dawn-userleft">
                            <img class="dawn-useravatar" src="{{ $user->iconUrl() }}" alt="icon">
                            <div class="dawn-username">{{ $user->name }}</div>
                        </div>

                        <div class="dawn-userright">
                            @if(in_array($user->id, $followingIds ?? [], true))
                                {{-- フォロー解除 --}}
                                <form method="POST" action="{{ route('follow.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="redirect" value="{{ url()->full() }}">
                                    <button type="submit" class="dawn-followbtn dawn-followbtn--danger">
                                        フォローをはずす
                                    </button>
                                </form>
                            @else
                                {{-- フォロー --}}
                                <form method="POST" action="{{ route('follow.store', $user->id) }}">
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
                    <div class="dawn-empty">該当するユーザーがいません。</div>
                @endforelse
            </div>

            <div class="dawn-pager">
                {{ $users->links() }}
            </div>
        </div>
    </section>

    {{-- 右：サイドバー（完成形に合わせて表示） --}}
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
