<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800">
                    Halo, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">Selamat datang di AI Sales Page Generator</p>
            </div>
            <a href="{{ route('sales-pages.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-indigo-200 transition">
                ✨ Generate Baru
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Sales Page</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Sepanjang waktu</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Berhasil</p>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $stats['generated'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Generated ✅</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Bulan Ini</p>
                    <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $stats['this_month'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ now()->translatedFormat('F Y') }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Gagal</p>
                    <p class="text-4xl font-bold text-red-400 mt-2">{{ $stats['failed'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Perlu di-retry ❌</p>
                </div>

            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('sales-pages.create') }}"
                    class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-8 flex items-center gap-5 text-white shadow-xl hover:shadow-2xl hover:scale-[1.01] transition">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center text-3xl shrink-0">
                        ✨
                    </div>
                    <div>
                        <h3 class="font-bold text-xl">Generate Sales Page</h3>
                        <p class="text-indigo-200 text-sm mt-1">Buat sales page baru dengan AI dalam hitungan detik</p>
                    </div>
                </a>

                <a href="{{ route('sales-pages.index') }}"
                    class="bg-white border border-gray-100 rounded-2xl p-8 flex items-center gap-5 shadow-sm hover:shadow-md hover:scale-[1.01] transition">
                    <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-3xl shrink-0">
                        📄
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">Lihat History</h3>
                        <p class="text-gray-500 text-sm mt-1">
                            {{ $stats['total'] > 0 ? $stats['total'] . ' sales page tersimpan' : 'Belum ada sales page' }}
                        </p>
                    </div>
                </a>
            </div>

            {{-- Recent Activity --}}
            @if ($recents->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-semibold text-gray-800">Aktivitas Terbaru</h3>
                        <a href="{{ route('sales-pages.index') }}" class="text-sm text-indigo-600 hover:underline">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach ($recents as $page)
                            <a href="{{ route('sales-pages.show', $page) }}"
                                class="flex items-center justify-between p-4 rounded-xl hover:bg-gray-50 transition group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-white text-sm shrink-0"
                                        style="background: linear-gradient(135deg,
                                            hsl({{ abs(crc32($page->product_name)) % 360 }}, 70%, 60%),
                                            hsl({{ (abs(crc32($page->product_name)) + 120) % 360 }}, 70%, 40%))">
                                        {{ strtoupper(substr($page->product_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm group-hover:text-indigo-600 transition">
                                            {{ $page->product_name }}
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $page->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                    {{ $page->status === 'generated'  ? 'bg-green-100 text-green-700'
                                    : ($page->status === 'failed'     ? 'bg-red-100 text-red-700'
                                    : ($page->status === 'processing' ? 'bg-blue-100 text-blue-700'
                                    :                                   'bg-yellow-100 text-yellow-700')) }}">
                                    {{ ucfirst($page->status) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>