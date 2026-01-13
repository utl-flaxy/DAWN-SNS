@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')
<div class="dawn-card" style="padding:18px;">
    <form method="POST" action="{{ route('users.update') }}" enctype="multipart/form-data">
        @csrf

        <div style="display:grid; grid-template-columns: 140px 1fr; gap:14px; align-items:center;">
            <div style="color:#666;">UserName</div>
            <div>
                <input class="dawn-input" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="dawn-error">{{ $message }}</div> @enderror
            </div>

            <div style="color:#666;">MailAddress</div>
            <div>
                <input class="dawn-input" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="dawn-error">{{ $message }}</div> @enderror
            </div>

            <div style="color:#666;">Password</div>
            <div>
                <input class="dawn-input" type="password" name="password" placeholder="変更する場合のみ入力">
                @error('password') <div class="dawn-error">{{ $message }}</div> @enderror
            </div>

            <div style="color:#666;">Password confirm</div>
            <div>
                <input class="dawn-input" type="password" name="password_confirmation" placeholder="確認入力">
            </div>

            <div style="color:#666;">Bio</div>
            <div>
                <textarea class="dawn-textarea" name="bio" rows="4" placeholder="自己紹介（任意）">{{ old('bio', $user->bio) }}</textarea>
                @error('bio') <div class="dawn-error">{{ $message }}</div> @enderror
            </div>

            <div style="color:#666;">Icon Image</div>
            <div>
                <input type="file" name="icon" accept="image/*">
                @error('icon') <div class="dawn-error">{{ $message }}</div> @enderror
                <div style="margin-top:10px; display:flex; align-items:center; gap:12px;">
                    <img src="{{ $user->iconUrl() }}" alt="icon" style="width:56px; height:56px; border-radius:9999px;">
                    <div style="color:#777; font-size:12px;">PNG/JPG / 最大2MB</div>
                </div>
            </div>
        </div>

        <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:12px;">
            <a class="dawn-btn dawn-btn--nav" href="{{ route('users.show', $user->id) }}">戻る</a>
            <button class="dawn-btn dawn-btn--primary" type="submit">更新</button>
        </div>
    </form>
</div>
@endsection
