@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')
<div class="dawn-card dawn-profile">
    <form method="POST" action="{{ route('users.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="dawn-profile__layout">

            {{-- 左：アイコン --}}
            <div class="dawn-profile__left">
                <div class="dawn-profile__avatarWrap">
                    <img class="dawn-profile__avatar" src="{{ $user->iconUrl() }}" alt="icon">
                </div>

                <div class="dawn-profile__fileHelp">PNG/JPG / 最大2MB</div>

                <div class="dawn-profile__fileRow">
                    <input class="dawn-profile__file" type="file" name="icon" accept="image/*">
                </div>

                @error('icon')
                    <div class="dawn-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- 右：フォーム --}}
            <div class="dawn-profile__right">

                <div class="dawn-formgrid">
                    <div class="dawn-formgrid__label">UserName</div>
                    <div class="dawn-formgrid__control">
                        <input class="dawn-input" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="dawn-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="dawn-formgrid__label">MailAddress</div>
                    <div class="dawn-formgrid__control">
                        <input class="dawn-input" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="dawn-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="dawn-formgrid__label">Password</div>
                    <div class="dawn-formgrid__control">
                        <input class="dawn-input" type="password" name="password" placeholder="変更する場合のみ入力">
                        @error('password') <div class="dawn-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="dawn-formgrid__label">Password confirm</div>
                    <div class="dawn-formgrid__control">
                        <input class="dawn-input" type="password" name="password_confirmation" placeholder="確認入力">
                    </div>

                    <div class="dawn-formgrid__label">Bio</div>
                    <div class="dawn-formgrid__control">
                        <textarea class="dawn-textarea dawn-textarea--bio" name="bio" rows="6" placeholder="自己紹介（任意）">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <div class="dawn-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="dawn-profile__actions">
                    <a class="dawn-btn dawn-btn--nav" href="{{ route('users.show', $user->id) }}">戻る</a>
                    <button class="dawn-btn dawn-btn--primary" type="submit">更新</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
