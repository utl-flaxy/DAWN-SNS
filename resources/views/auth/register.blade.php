<x-guest-layout>
    <div class="text-center text-white/90 mb-6">
        <div class="text-lg font-medium">新規ユーザー登録</div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="text-left">
            <label class="block text-xs mb-1 text-white/80">UserName</label>
            <input
                name="name"
                type="text"
                value="{{ old('name') }}"
                required
                autofocus
                class="input-dawn"
                placeholder="dawntown"
            />
            @error('name')
                <p class="text-xs text-red-200 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-left">
            <label class="block text-xs mb-1 text-white/80">MailAddress</label>
            <input
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                class="input-dawn"
                placeholder="dawn@dawn.jp"
            />
            @error('email')
                <p class="text-xs text-red-200 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-left">
            <label class="block text-xs mb-1 text-white/80">Password</label>
            <input
                name="password"
                type="password"
                required
                class="input-dawn"
                placeholder="••••••••"
            />
            @error('password')
                <p class="text-xs text-red-200 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-left">
            <label class="block text-xs mb-1 text-white/80">Password confirm</label>
            <input
                name="password_confirmation"
                type="password"
                required
                class="input-dawn"
                placeholder="••••••••"
            />
        </div>

        <button class="w-full btn-dawn-register">
            REGISTER
        </button>

        <div class="text-center text-xs text-white/80 pt-2">
            <a class="hover:underline" href="{{ route('login') }}">ログイン画面へ戻る</a>
        </div>
    </form>
</x-guest-layout>
