@extends('layouts.app')
@section('title', '投稿編集')

@section('content')
<h1 class="dawn-h1">投稿を編集</h1>

<div class="dawn-card">
    <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')

        <textarea name="body" class="dawn-textarea" rows="6" required>{{ old('body', $post->body) }}</textarea>

        @error('body')
            <div class="dawn-error">{{ $message }}</div>
        @enderror

        <div class="dawn-actions">
            <a class="dawn-btn dawn-btn--ghost" href="{{ route('posts.index') }}">戻る</a>
            <button class="dawn-btn dawn-btn--primary" type="submit">更新</button>
        </div>
    </form>
</div>
@endsection
