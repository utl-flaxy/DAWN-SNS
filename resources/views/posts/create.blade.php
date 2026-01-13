@extends('layouts.app')

@section('title', '投稿する')

@section('content')
<div class="dawn-pagehead">
    <h1 class="dawn-h1">投稿する</h1>
</div>

<div class="dawn-card">
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <textarea name="content" class="dawn-textarea" rows="6" placeholder="メッセージを投稿..." required>{{ old('content') }}</textarea>

        @error('content')
            <div class="dawn-error">{{ $message }}</div>
        @enderror

        <div style="margin-top:12px; display:flex; gap:12px; justify-content:flex-end;">
            <a class="dawn-btn dawn-btn--nav" href="{{ route('posts.index') }}">戻る</a>
            <button class="dawn-btn dawn-btn--primary" type="submit">投稿</button>
        </div>
    </form>
</div>
@endsection
