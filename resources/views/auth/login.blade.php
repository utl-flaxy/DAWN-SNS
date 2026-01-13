<x-guest-layout>
    @php($subtitle = 'Social Network Service')

    <div class="text-center text-white/90 mb-6">
        <div class="text-lg font-medium">DAWNのSNSへようこそ</div>
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm text-white/80">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="text-left">
            <label class="block text-xs mb-1 text-white/80">MailAddress</label>
            <input
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="input-dawn"
                placeholder="example@mail.com"
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

        <div class="flex items-center gap-2 text-left">
            <input id="remember_me" name="remember" type="checkbox" class="rounded border-white/30 bg-white/10">
            <label for="remember_me" class="text-xs text-white/80">ログイン情報を記憶する</label>
        </div>

        <button class="w-full btn-dawn">
            LOGIN
        </button>

        <div class="flex items-center justify-between text-xs text-white/80 pt-1">
            @if (Route::has('password.request'))
                <a class="hover:underline" href="{{ route('password.request') }}">パスワードをお忘れですか？</a>
            @endif
            <a class="hover:underline" href="{{ route('register') }}">新規ユーザーの方はこちら</a>
        </div>
    </form>
</x-guest-layout>
