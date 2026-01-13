@extends('layouts.app')

@section('title', 'タイムライン')

@section('content')
<header class="bg-[#3E4865] text-white flex items-center justify-between px-6 py-3">
  <div>
    <img src="{{ asset('img/main_logo.png') }}" alt="DAWN Logo" class="h-8">
  </div>
  <div class="relative">
    <button id="menuToggle" class="flex items-center space-x-2 focus:outline-none">
      <span>{{ Auth::user()->name ?? 'Guest' }}</span>
      <img src="{{ asset('img/dawn.png') }}" alt="User Icon" class="w-8 h-8 rounded-full border border-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-white" viewBox="0 0 20 20"><path d="M5.25 7.5L10 12.25L14.75 7.5H5.25Z"/></svg>
    </button>
    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 bg-white text-gray-700 rounded shadow-md w-40">
      <a href="{{ route('timeline.index') }}" class="block px-4 py-2 hover:bg-gray-100">HOME</a>
      <a href="{{ route('users.edit') }}" class="block px-4 py-2 hover:bg-gray-100">プロフィール編集</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">ログアウト</button>
      </form>
    </div>
  </div>
</header>

<main class="flex justify-center py-8 px-4">
  <section class="w-full max-w-2xl mr-8">
    <!-- 投稿フォーム -->
    <div class="bg-white rounded-md p-4 mb-6 flex items-center shadow-md">
      <img src="{{ asset('img/dawn.png') }}" alt="User Icon" class="w-10 h-10 rounded-full mr-3">
      <form method="POST" action="{{ route('posts.store') }}" class="flex-grow flex items-center">
        @csrf
        <input type="text" name="content" placeholder="何をつぶやこうか...？" class="flex-grow border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-[#3E4865]">
        <button type="submit" class="ml-3 bg-[#3E4865] p-2 rounded hover:opacity-80 transition">
          <img src="{{ asset('img/post.png') }}" alt="Post" class="w-6">
        </button>
      </form>
    </div>

    <!-- 投稿一覧 -->
    @foreach($posts as $post)
      <div class="bg-white rounded-md p-4 mb-4 shadow-md relative group">
        <div class="flex items-center mb-2">
          <img src="{{ asset('img/dawn.png') }}" alt="User Icon" class="w-10 h-10 rounded-full mr-3">
          <div>
            <p class="font-semibold">{{ $post->user->name }}</p>
            <p class="text-xs text-gray-400">{{ $post->created_at->format('Y-m-d H:i') }}</p>
          </div>
        </div>
        <p class="mb-4 whitespace-pre-line">{{ $post->content }}</p>

        @if(Auth::id() === $post->user_id)
          <div class="absolute right-4 bottom-3 flex space-x-3 opacity-0 group-hover:opacity-100 transition">
            <a href="{{ route('posts.edit', $post->id) }}"><img src="{{ asset('img/edit.png') }}" alt="Edit" class="w-5 h-5"></a>
            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="hover-trash">
              @csrf
              @method('DELETE')
              <button type="submit"><img src="{{ asset('img/trash.png') }}" alt="Trash" class="w-5 h-5"></button>
            </form>
          </div>
        @endif
      </div>
    @endforeach
  </section>

  <aside class="w-64 bg-white p-4 rounded-md shadow-md">
    <p class="text-sm mb-2">{{ Auth::user()->name ?? 'ゲスト' }} さんの</p>
    <div class="flex justify-between items-center mb-2">
      <span>フォロー数</span><a href="#" class="bg-[#3E4865] text-white px-3 py-1 rounded text-sm">{{ $followCount ?? 0 }}名</a>
    </div>
    <div class="flex justify-between items-center mb-4">
      <span>フォロワー数</span><a href="#" class="bg-[#3E4865] text-white px-3 py-1 rounded text-sm">{{ $followerCount ?? 0 }}名</a>
    </div>
    <a href="{{ route('user.search') }}" class="block text-center bg-[#3E4865] text-white py-2 rounded hover:bg-[#2E364C] transition">ユーザー検索</a>
  </aside>
</main>

@push('scripts')
<script>
  document.getElementById('menuToggle').addEventListener('click', () => {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
  });
</script>
@endpush
@endsection
