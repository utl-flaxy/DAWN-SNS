<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'DAWN SNS')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="dawn-body">
    {{-- Header --}}
    <header class="dawn-header">
        <div class="dawn-header__inner">

            {{-- ロゴ（画像） --}}
            <a class="dawn-logo" href="{{ route('posts.index') }}" title="Topへ">
                <img class="dawn-logo__img" src="{{ asset('assets/brand/logo.png') }}" alt="DAWN">
            </a>

            @auth
                @php $me = auth()->user(); @endphp

                {{-- 右上：ユーザー名 + ▼ + アイコン --}}
                <div class="dawn-user" id="dawnUserMenu">
                    <span class="dawn-user__name">{{ $me->name }} さん</span>

                    <button type="button"
                            class="dawn-user__toggle"
                            id="dawnUserMenuBtn"
                            aria-haspopup="true"
                            aria-expanded="false">
                        ▼
                    </button>

                    <img class="dawn-user__icon" src="{{ $me->iconUrl() }}" alt="icon">

                    {{-- ドロップダウン --}}
                    <div class="dawn-dropdown is-hidden" id="dawnDropdown">
                        <a class="dawn-dropdown__item dawn-dropdown__item--home" href="{{ route('posts.index') }}">HOME</a>
                        <a class="dawn-dropdown__item" href="{{ route('users.edit') }}">プロフィール編集</a>

                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="dawn-dropdown__item">ログアウト</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    <main class="dawn-container">
        {{-- Flash --}}
        @if(session('success'))
            <div class="dawn-flash">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <script>
        // 右上プルダウン：開閉 + 外クリックで閉じる + ESCで閉じる
        (() => {
            const wrap = document.getElementById('dawnUserMenu');
            const btn  = document.getElementById('dawnUserMenuBtn');
            const menu = document.getElementById('dawnDropdown');

            if (!wrap || !btn || !menu) return;

            const open = () => {
                menu.classList.remove('is-hidden');
                btn.setAttribute('aria-expanded', 'true');
            };

            const close = () => {
                menu.classList.add('is-hidden');
                btn.setAttribute('aria-expanded', 'false');
            };

            const toggle = () => {
                if (menu.classList.contains('is-hidden')) open();
                else close();
            };

            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                toggle();
            });

            // wrap 内クリックは外クリック扱いにしない
            wrap.addEventListener('click', (e) => e.stopPropagation());

            // 外クリックで閉じる
            document.addEventListener('click', () => close());

            // ESCで閉じる
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') close();
            });
        })();
    </script>
</body>
</html>
