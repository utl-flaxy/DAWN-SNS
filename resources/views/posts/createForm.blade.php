<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規投稿
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        {{-- バリデーションエラー表示 --}}
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.create') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="post" class="block font-medium text-sm text-gray-700">
                    投稿内容
                </label>
                <textarea name="post" id="post" rows="4" class="w-full border rounded-md p-2">{{ old('post') }}</textarea>
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    投稿する
                </button>
                <a href="{{ route('posts.index') }}" class="ml-4 text-gray-600 hover:underline">
                    戻る
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
