<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                <span class="text-white text-sm">✨</span>
            </div>
            <h2 class="font-semibold text-xl text-gray-800">Generate Sales Page</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Hero Card --}}
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 mb-8 text-white shadow-xl">
                <h3 class="text-xl font-bold mb-1">AI Sales Page Generator 🚀</h3>
                <p class="text-indigo-200 text-sm">Isi informasi produk kamu, dan biarkan AI membuatkan sales page yang
                    persuasif dalam hitungan detik.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
                        <p class="text-sm font-medium text-red-700 mb-1">Ada yang perlu diperbaiki:</p>
                        <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('sales-pages.store') }}" id="generate-form">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Product Name --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Nama Produk / Layanan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="product_name" value="{{ old('product_name') }}"
                                placeholder="e.g. EduPro — Platform Belajar Online"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('product_name')
                                <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Deskripsi Produk <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" rows="3" placeholder="Jelaskan produk/layanan kamu secara singkat dan menarik..."
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                        </div>

                        {{-- Features --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Fitur Utama <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="features" value="{{ old('features') }}"
                                placeholder="Video HD, Sertifikat, Live Mentoring, Forum Diskusi"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-xs text-gray-400 mt-1.5">💡 Pisahkan dengan koma</p>
                        </div>

                        {{-- Target Audience --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Target Audience <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="target_audience" value="{{ old('target_audience') }}"
                                placeholder="e.g. Mahasiswa usia 18-25 tahun"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="price" value="{{ old('price') }}"
                                placeholder="e.g. Rp 299.000/bulan"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>

                        {{-- USP --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Unique Selling Point <span class="text-red-500">*</span>
                            </label>
                            <textarea name="unique_selling_point" rows="3" placeholder="Apa yang membuat produk kamu berbeda dari kompetitor?"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('unique_selling_point') }}</textarea>
                        </div>
                    </div>

                    {{-- Template Shortcuts --}}
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">⚡ Quick Templates
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="fillTemplate('saas')"
                                class="text-xs bg-gray-100 hover:bg-indigo-100 hover:text-indigo-700 text-gray-600 px-3 py-1.5 rounded-lg transition">
                                SaaS Product
                            </button>
                            <button type="button" onclick="fillTemplate('course')"
                                class="text-xs bg-gray-100 hover:bg-indigo-100 hover:text-indigo-700 text-gray-600 px-3 py-1.5 rounded-lg transition">
                                Online Course
                            </button>
                            <button type="button" onclick="fillTemplate('agency')"
                                class="text-xs bg-gray-100 hover:bg-indigo-100 hover:text-indigo-700 text-gray-600 px-3 py-1.5 rounded-lg transition">
                                Agency Service
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn"
                        class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3.5 px-6 rounded-xl transition shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
                        <span id="btn-icon">✨</span>
                        <span id="btn-text">Generate Sales Page dengan AI</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const templates = {
            saas: {
                product_name: 'TaskFlow Pro — Project Management Tool',
                description: 'Platform manajemen proyek berbasis AI yang membantu tim bekerja lebih efisien dengan fitur otomatisasi tugas dan analitik real-time.',
                features: 'Dashboard Analytics, AI Task Automation, Team Collaboration, Gantt Chart, Time Tracking, API Integration',
                target_audience: 'Startup founder dan tim product usia 25-40 tahun',
                price: 'Rp 199.000/bulan (free trial 14 hari)',
                unique_selling_point: 'Satu-satunya tool yang menggunakan AI untuk otomatis memprioritaskan task berdasarkan deadline dan kapasitas tim.'
            },
            course: {
                product_name: 'FullStack Mastery — Bootcamp Web Development',
                description: 'Program intensif 12 minggu untuk menguasai React, Node.js, dan deploy aplikasi production dari nol hingga dapat kerja.',
                features: 'Live Mentoring, Project Nyata, Sertifikat, Job Placement, Akses Seumur Hidup, Forum Alumni',
                target_audience: 'Fresh graduate dan career switcher usia 20-30 tahun',
                price: 'Rp 3.500.000 (cicilan tersedia)',
                unique_selling_point: 'Garansi uang kembali 100% jika tidak dapat pekerjaan dalam 6 bulan setelah lulus.'
            },
            agency: {
                product_name: 'DigitalBoost Agency — Jasa Digital Marketing',
                description: 'Layanan digital marketing full-service yang fokus pada peningkatan revenue bisnis melalui strategi berbasis data.',
                features: 'SEO & SEM, Social Media Management, Iklan Meta & Google, Konten Kreatif, Laporan Bulanan',
                target_audience: 'Pemilik bisnis UMKM dan startup usia 28-45 tahun',
                price: 'Mulai dari Rp 5.000.000/bulan',
                unique_selling_point: 'ROI-guaranteed: jika revenue tidak naik 30% dalam 3 bulan, kami kerjakan gratis bulan berikutnya.'
            }
        };

        function fillTemplate(type) {
            const t = templates[type];
            document.querySelector('[name="product_name"]').value = t.product_name;
            document.querySelector('[name="description"]').value = t.description;
            document.querySelector('[name="features"]').value = t.features;
            document.querySelector('[name="target_audience"]').value = t.target_audience;
            document.querySelector('[name="price"]').value = t.price;
            document.querySelector('[name="unique_selling_point"]').value = t.unique_selling_point;
        }

        document.getElementById('generate-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            const icon = document.getElementById('btn-icon');
            const text = document.getElementById('btn-text');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            icon.innerHTML =
                `<svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>`;
            text.textContent = 'Mengirim ke AI...';
        });
    </script>
</x-app-layout>
