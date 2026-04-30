# ✨ AI Sales Page Generator

> Transformasi informasi produk menjadi sales page yang persuasif dan profesional dalam hitungan detik — powered by Google Gemini AI.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-38BDF8?style=flat-square&logo=tailwindcss&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-18-4169E1?style=flat-square&logo=postgresql&logoColor=white)
![Laravel Cloud](https://img.shields.io/badge/Deployed-Laravel%20Cloud-FF2D20?style=flat-square&logo=laravel&logoColor=white)

**🔗 Live Demo:** [ai-sales-generator-main-jdl0gr.free.laravel.cloud](https://ai-sales-generator-main-jdl0gr.free.laravel.cloud)

---

## 📌 Daftar Isi

- [Tentang Aplikasi](#-tentang-aplikasi)
- [Fitur](#-fitur)
- [Tech Stack](#-tech-stack)
- [Prasyarat](#-prasyarat)
- [Instalasi Lokal](#-instalasi-lokal)
- [Konfigurasi Environment](#-konfigurasi-environment)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Struktur Folder](#-struktur-folder)
- [Cara Penggunaan](#-cara-penggunaan)
- [Akun Demo](#-akun-demo)
- [Deploy ke Laravel Cloud](#-deploy-ke-laravel-cloud)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Troubleshooting](#-troubleshooting)

---

## 🎯 Tentang Aplikasi

**AI Sales Page Generator** adalah aplikasi web yang membantu pemilik bisnis, marketer, dan entrepreneur untuk membuat halaman penjualan (sales page) yang lengkap dan persuasif secara otomatis menggunakan kecerdasan buatan.

Cukup isi informasi dasar produk kamu, dan AI akan menghasilkan sales page yang siap pakai — lengkap dengan headline, benefit section, pricing, social proof, hingga call-to-action yang dirender sebagai halaman web sungguhan.

### Alur Aplikasi

```
Register / Login
      ↓
Isi Form Produk
(nama, deskripsi, fitur, target audience, harga, USP)
      ↓
Content Moderation (2-layer: keyword + AI check)
      ↓
AI Generate Sales Page (background queue job)
      ↓
Live Preview Sales Page (rendered sebagai landing page)
      ↓
Export HTML / Generate Ulang / Simpan ke History
```

---

## 🚀 Fitur

### Wajib (Semua Terpenuhi ✅)

- ✅ **User Authentication** — Register, login, logout via Laravel Breeze
- ✅ **Form Input Produk** — Input terstruktur dengan 3 quick templates
- ✅ **AI Generation** — Generate sales page lengkap via Google Gemini API
- ✅ **Loading State** — Auto-refresh setiap 5 detik saat processing
- ✅ **Error Handling** — Status `failed` dengan opsi retry
- ✅ **History Page** — Lihat, search, dan kelola semua sales page
- ✅ **Live Preview** — Sales page dirender dalam iframe seperti landing page sungguhan
- ✅ **Re-generate** — Generate ulang dengan variasi berbeda

### Bonus

- ✅ **Export HTML** — Download hasil sebagai file `.html` siap publish
- ✅ **Quick Templates** — 3 pre-filled template (SaaS, Online Course, Agency)
- ✅ **Copy HTML** — Salin kode HTML ke clipboard
- ✅ **Content Moderation** — 2-layer filter (keyword + AI) untuk konten halal
- ✅ **Rate Limiting** — Max 10 generate per menit per user
- ✅ **Usage Stats Dashboard** — Statistik penggunaan real-time
- ✅ **Background Queue Job** — Proses AI di background, tidak timeout
- ✅ **Search History** — Cari sales page berdasarkan nama/deskripsi

---

## 🛠 Tech Stack

| Layer    | Teknologi                       |
| -------- | ------------------------------- |
| Backend  | Laravel 11 (PHP 8.2+)           |
| Frontend | Blade Templates + Tailwind CSS  |
| AI API   | Google Gemini 1.5 Flash         |
| Database | PostgreSQL 18 (Serverless)      |
| Queue    | Laravel Queue (database driver) |
| Hosting  | Laravel Cloud                   |
| Font     | Google Fonts (Sora)             |

---

## ✅ Prasyarat

Pastikan sudah terinstall:

- **PHP** >= 8.2 dengan extension `pdo_pgsql`
- **Composer** >= 2.x
- **Node.js** >= 18.x & npm
- **PostgreSQL** (lokal) atau akun **Laravel Cloud** (cloud)
- **Google Gemini API Key** — gratis di [aistudio.google.com](https://aistudio.google.com)

---

## 💻 Instalasi Lokal

### 1. Clone Repository

```bash
git clone https://github.com/Yoravo/ai-sales-generator.git
cd ai-sales-generator
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Copy File Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Buat database baru di PostgreSQL:

```sql
CREATE DATABASE ai_sales_generator;
```

### 5. Jalankan Migration

```bash
php artisan migrate
```

### 6. Build Assets

```bash
npm run build
```

---

## ⚙️ Konfigurasi Environment

Edit file `.env`:

```env
# App
APP_NAME="AI Sales Page Generator"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ai_sales_generator
DB_USERNAME=postgres
DB_PASSWORD=

# Queue
QUEUE_CONNECTION=database

# Cache & Session
CACHE_STORE=database
SESSION_DRIVER=database

# Google Gemini AI
GEMINI_API_KEY=           # Dapatkan di aistudio.google.com (gratis)
GEMINI_API_URL=https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent
```

### Cara Mendapatkan Gemini API Key (Gratis)

1. Buka [aistudio.google.com](https://aistudio.google.com)
2. Login dengan Google account
3. Klik **"Get API Key"** → **"Create API key"**
4. Copy key dan paste ke `GEMINI_API_KEY` di `.env`

---

## ▶️ Menjalankan Aplikasi

Butuh **3 terminal** yang berjalan bersamaan:

### Terminal 1 — Web Server

```bash
php artisan serve
```

### Terminal 2 — Queue Worker (wajib untuk AI generation)

```bash
php artisan queue:work --sleep=3 --tries=3 --timeout=120
```

### Terminal 3 — Tailwind Watcher

```bash
npm run dev
```

Buka browser: **http://localhost:8000**

> ⚠️ Queue worker **wajib berjalan** agar proses generate AI bisa bekerja. Tanpa queue worker, status akan stuck di `processing`.

---

## 📁 Struktur Folder

```
ai-sales-generator/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php       # Stats & recent activity
│   │   └── SalesPageController.php       # CRUD + generate + export + preview
│   ├── Jobs/
│   │   └── GenerateSalesPageJob.php      # Background AI generation
│   ├── Models/
│   │   ├── User.php
│   │   └── SalesPage.php
│   └── Services/
│       ├── ContentModerationService.php  # 2-layer content filter
│       └── GeminiService.php             # Gemini API + prompt engineering
├── database/migrations/
│   └── xxxx_create_sales_pages_table.php
├── resources/views/
│   ├── welcome.blade.php                 # Landing page
│   ├── dashboard.blade.php               # Stats dashboard
│   └── sales-pages/
│       ├── create.blade.php              # Form input + quick templates
│       ├── index.blade.php               # History + search
│       └── show.blade.php                # Preview + export + copy HTML
├── routes/web.php
└── nixpacks.toml
```

---

## 📖 Cara Penggunaan

### 1. Buat Akun

- Klik **"Mulai Gratis"** di landing page
- Isi nama, email, dan password

### 2. Generate Sales Page

- Dari dashboard, klik **"Generate Sales Page"**
- Isi semua field yang diperlukan:
    - **Nama Produk** — nama produk/layanan kamu
    - **Deskripsi** — penjelasan singkat produk
    - **Fitur Utama** — pisahkan dengan koma (e.g. `Video HD, Sertifikat, Mentoring`)
    - **Target Audience** — siapa yang dituju
    - **Harga** — format bebas (e.g. `Rp 299.000/bulan`)
    - **Unique Selling Point** — keunggulan dibanding kompetitor
- Atau gunakan **Quick Templates** untuk mengisi otomatis contoh data
- Klik **"Generate Sales Page dengan AI"**

### 3. Tunggu Proses AI

- Halaman otomatis refresh setiap 5 detik
- Selesai dalam 15-30 detik
- Status berubah dari `Processing` → `Generated`

### 4. Preview & Export

- Sales page dirender langsung sebagai live preview
- Klik **"Export HTML"** untuk download file `.html`
- Klik **"Copy HTML"** untuk salin ke clipboard
- Klik **"Generate Ulang"** untuk variasi berbeda

### 5. Kelola History

- Buka **"History"** untuk lihat semua sales page
- Gunakan search bar untuk mencari
- Klik **"Hapus"** untuk menghapus

---

## 🔑 Akun Demo

| Field        | Value          |
| ------------ | -------------- |
| **Email**    | demo@gmail.com |
| **Password** | demo123        |

> 💡 App mungkin perlu 5-10 detik untuk wake up pertama kali dibuka (normal untuk free tier hibernation).

---

## ☁️ Deploy ke Laravel Cloud

### Prasyarat

- Akun [Laravel Cloud](https://cloud.laravel.com) (login dengan GitHub)
- Repository sudah di-push ke GitHub

### Langkah Deploy

**1. Buat Application Baru**

```
New Application → Deploy from GitHub → Pilih repo → Branch: main
```

**2. Database otomatis dibuat** — Laravel Cloud provision PostgreSQL serverless

**3. Set Custom Environment Variables**

Di Settings → Environment → Custom environment variables:

```env
APP_KEY=base64:xxxx...
QUEUE_CONNECTION=database
CACHE_STORE=database
SESSION_DRIVER=database
GEMINI_API_KEY=
GEMINI_API_URL=https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent
```

> DB credentials dan APP_URL otomatis di-inject oleh Laravel Cloud.

**4. Setup Queue Worker**

Di Environment → App Cluster → Background Processes → Custom Worker:

```
php artisan queue:work --sleep=3 --tries=3 --timeout=120 --max-time=3600
```

**5. Klik Deploy!**

**6. Buat dummy account setelah deploy:**

```bash
php artisan tinker
\App\Models\User::create([
    'name'     => 'Demo User',
    'email'    => 'demo@aisales.com',
    'password' => bcrypt('demo123456'),
]);
```

---

## 🏗 Arsitektur Sistem

```
┌─────────────────────────────────────────────────────┐
│                   User Browser                       │
└────────────────────┬────────────────────────────────┘
                     │ HTTPS Request
                     ▼
┌─────────────────────────────────────────────────────┐
│           Laravel 11 (Laravel Cloud)                 │
│                                                      │
│  ContentModerationService                            │
│  ├── Layer 1: Keyword filter (0 API call)           │
│  └── Layer 2: Gemini AI check (~50 token)           │
│                     ↓ PASS                           │
│  SalesPageController                                 │
│  └── dispatch(GenerateSalesPageJob)                  │
│                     ↓                                │
│  Queue (database driver)                             │
│  └── Background Worker (always running)              │
│       └── GenerateSalesPageJob                       │
│            └── GeminiService                         │
└──────────────────────┬──────────────────────────────┘
                       │ HTTP POST
                       ▼
┌─────────────────────────────────────────────────────┐
│           Google Gemini 1.5 Flash API                │
│  Input:  product data + prompt engineering           │
│  Output: complete sales page HTML (max 65k token)    │
└─────────────────────────────────────────────────────┘
```

### Status Flow Sales Page

```
[Form Submit] → processing → generated → .html export
                    │
                    └── failed → retry → processing
```

---

## 🐛 Troubleshooting

**Status stuck di `processing`**
Queue worker tidak berjalan. Jalankan `php artisan queue:work` di local, atau pastikan Background Process sudah dibuat di Laravel Cloud.

**Output HTML terpotong**
Cek `maxOutputTokens` di `GeminiService.php` — harus `65536`.

**Konten ditolak moderasi**
Input mengandung kata kunci yang melanggar kebijakan konten. Pastikan produk halal dan sesuai kebijakan penggunaan.

**Rate limit error (429)**
Terlalu banyak request dalam 1 menit. Tunggu 60 detik dan coba lagi.

**App lambat pertama kali dibuka**
Normal untuk free tier — app hibernate setelah tidak ada traffic. Wake up otomatis dalam 5-10 detik.

---

## 👨‍💻 Developer

**Radja Ravine Salfriandry**

- 🌐 Portfolio: [portofolio-radja-ravine-salfriandry.vercel.app](https://portofolio-radja-ravine-salfriandry.vercel.app)
- 📧 Email: ravinesalf@gmail.com
- 💼 GitHub: [github.com/Yoravo](https://github.com/Yoravo)

---

_Dibuat sebagai bagian dari technical task PT Dakwah Digital Network — April 2026_
