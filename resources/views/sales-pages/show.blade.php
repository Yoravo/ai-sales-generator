<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('sales-pages.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    ←
                </a>
                <h2 class="font-semibold text-xl text-gray-800">{{ $salesPage->product_name }}</h2>
                <span
                    class="text-xs px-2.5 py-1 rounded-full font-medium
                    {{ $salesPage->status === 'generated'
                        ? 'bg-green-100 text-green-700'
                        : ($salesPage->status === 'failed'
                            ? 'bg-red-100 text-red-700'
                            : ($salesPage->status === 'processing'
                                ? 'bg-blue-100 text-blue-700'
                                : 'bg-yellow-100 text-yellow-700')) }}">
                    {{ ucfirst($salesPage->status) }}
                </span>
            </div>
            <div class="flex gap-2">
                <form method="POST" action="{{ route('sales-pages.regenerate', $salesPage) }}">
                    @csrf
                    <button type="submit"
                        class="bg-white border border-gray-200 hover:border-indigo-400 text-gray-700 hover:text-indigo-600 text-sm font-medium py-2 px-3 rounded-xl transition">
                        🔄 Generate Ulang
                    </button>
                </form>
                @if ($salesPage->status === 'generated')
                    <button id="copy-btn" onclick="copyHTML()"
                        class="bg-white border border-gray-200 hover:border-indigo-400 text-gray-700 hover:text-indigo-600 text-sm font-medium py-2 px-3 rounded-xl transition">
                        📋 Copy HTML
                    </button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="mb-4 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl flex items-center gap-2">
                    <span>❌</span> {{ session('error') }}
                </div>
            @endif

            {{-- Info Bar --}}
            <div class="bg-white border border-gray-100 rounded-xl p-4 mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Produk</p>
                    <p class="text-sm font-semibold text-gray-700 mt-0.5 truncate">{{ $salesPage->product_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Harga</p>
                    <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $salesPage->price }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Target</p>
                    <p class="text-sm font-semibold text-gray-700 mt-0.5 truncate">{{ $salesPage->target_audience }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Dibuat</p>
                    <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $salesPage->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            {{-- Processing State --}}
            @if ($salesPage->status === 'processing')
                <div class="bg-white border border-blue-100 rounded-2xl p-16 text-center">
                    <div class="flex flex-col items-center gap-4">
                        <div class="relative">
                            <div
                                class="animate-spin rounded-full h-16 w-16 border-4 border-indigo-100 border-t-indigo-600">
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center text-2xl">✨</div>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-800">AI sedang membuat sales page kamu...</p>
                            <p class="text-sm text-gray-400 mt-1">Biasanya membutuhkan 15-30 detik ⏳</p>
                        </div>
                        <div class="flex gap-1 mt-2">
                            <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0ms">
                            </div>
                            <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce"
                                style="animation-delay: 150ms"></div>
                            <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce"
                                style="animation-delay: 300ms"></div>
                        </div>
                    </div>
                </div>
                <script>
                    setTimeout(() => window.location.reload(), 5000);
                </script>

                {{-- Generated State --}}
            @elseif ($salesPage->status === 'generated' && $salesPage->generated_html)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    {{-- Browser Bar --}}
                    <div class="bg-gray-50 border-b border-gray-100 px-4 py-3 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                        <div
                            class="flex-1 bg-white border border-gray-200 rounded-lg px-3 py-1 text-xs text-gray-400 text-center mx-4">
                            preview — {{ str($salesPage->product_name)->slug() }}.html
                        </div>
                    </div>
                    <iframe src="{{ route('sales-pages.preview', $salesPage) }}" class="w-full border-0"
                        style="height: 900px;"
                        onload="this.style.height = (this.contentWindow.document.body.scrollHeight + 50) + 'px'">
                    </iframe>
                </div>

                {{-- Failed State --}}
            @elseif ($salesPage->status === 'failed')
                <div class="bg-white rounded-2xl border border-red-100 p-16 text-center">
                    <div class="text-5xl mb-4">❌</div>
                    <h3 class="font-semibold text-gray-800 text-lg">Generate Gagal</h3>
                    <p class="text-sm text-gray-400 mt-2 mb-6">Mungkin ada masalah dengan API atau koneksi. Coba
                        generate ulang.</p>
                    <form method="POST" action="{{ route('sales-pages.regenerate', $salesPage) }}">
                        @csrf
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-xl transition">
                            🔄 Coba Lagi
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
    <script>
        async function copyHTML() {
            const btn = document.getElementById('copy-btn');
            try {
                const response = await fetch('{{ route('sales-pages.preview', $salesPage) }}');
                const html = await response.text();
                await navigator.clipboard.writeText(html);
                btn.textContent = '✅ Copied!';
                btn.classList.add('border-green-400', 'text-green-600');
            } catch (err) {
                btn.textContent = '❌ Gagal';
            } finally {
                setTimeout(() => {
                    btn.textContent = '📋 Copy HTML';
                    btn.classList.remove('border-green-400', 'text-green-600');
                }, 2000);
            }
        }
    </script>
</x-app-layout>
