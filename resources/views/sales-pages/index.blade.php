<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-sm">📄</span>
                </div>
                <h2 class="font-semibold text-xl text-gray-800">History Sales Pages</h2>
            </div>
            <a href="{{ route('sales-pages.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-xl shadow-lg shadow-indigo-200 transition flex items-center gap-2">
                ✨ Generate Baru
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('sales-pages.index') }}" class="mb-6">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari sales page..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 pr-12 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <button type="submit"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600">
                        🔍
                    </button>
                </div>
            </form>
            @forelse ($salesPages as $page)
                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-4 hover:shadow-md transition group">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600 transition">
                                    <a href="{{ route('sales-pages.show', $page) }}"> {{ $page->product_name }}</a>
                                </h3>
                                <span
                                    class="inline-flex items-center text-xs px-2.5 py-1 rounded-full font-medium
                                    {{ $page->status === 'generated'
                                        ? 'bg-green-100 text-green-700'
                                        : ($page->status === 'failed'
                                            ? 'bg-red-100 text-red-700'
                                            : ($page->status === 'processing'
                                                ? 'bg-blue-100 text-blue-700'
                                                : 'bg-yellow-100 text-yellow-700')) }}">
                                    {{ $page->status === 'processing' ? '⚡ Processing...' : ucfirst($page->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 line-clamp-1">{{ $page->description }}</p>
                            <p class="text-xs text-gray-400 mt-2">
                                🕐 {{ $page->created_at->diffForHumans() }}
                                &nbsp;·&nbsp;
                                💰 {{ $page->price }}
                                &nbsp;·&nbsp;
                                👥 {{ $page->target_audience }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a href="{{ route('sales-pages.show', $page) }}"
                                class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-sm font-medium py-2 px-3 rounded-lg transition">
                                Preview
                            </a>
                            <form method="POST" action="{{ route('sales-pages.destroy', $page) }}"
                                onsubmit="return confirm('Hapus sales page ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="bg-red-50 hover:bg-red-100 text-red-500 text-sm font-medium py-2 px-3 rounded-lg transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-16 text-center">
                    <div class="text-5xl mb-4">✨</div>
                    <h3 class="font-semibold text-gray-700 text-lg">Belum ada sales page</h3>
                    <p class="text-gray-400 text-sm mt-1 mb-6">Buat sales page pertama kamu dengan AI sekarang!</p>
                    <a href="{{ route('sales-pages.create') }}"
                        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-xl transition">
                        Generate Sekarang
                    </a>
                </div>
            @endforelse

            <div class="mt-6">{{ $salesPages->links() }}</div>
        </div>
    </div>
</x-app-layout>
