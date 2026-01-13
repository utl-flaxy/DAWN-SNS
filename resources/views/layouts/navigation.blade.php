<nav class="bg-dawn-header text-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="h-14 flex items-center justify-between">
            {{-- Left: Logo --}}
            <a href="{{ route('posts.index') }}" class="flex items-center gap-3">
                <x-application-logo class="h-8 w-8" />
                <span class="tracking-[0.35em] font-semibold">DAWN</span>
            </a>

            {{-- Right: user dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button
                    type="button"
                    @click="open = !open"
                    class="flex items-center gap-2 hover:opacity-90"
                >
                    <span class="text-sm">{{ Auth::user()->name }} さん</span>
                    <span class="text-xs">▼</span>
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20">
                        👤
                    </span>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    @click.outside="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white text-gray-800 shadow-lg border"
                >
                    <a href="{{ route('posts.index') }}" class="block px-4 py-3 hover:bg-gray-50 border-b">
                        HOME
                    </a>
                    <a href="{{ route('users.edit') }}" class="block px-4 py-3 hover:bg-gray-50 border-b">
                        プロフィール編集
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-50">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
