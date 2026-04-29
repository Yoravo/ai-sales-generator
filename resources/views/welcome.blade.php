<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Sales Page Generator — Buat Sales Page dalam Detik</title>
    <meta name="description"
        content="Transformasi informasi produk menjadi sales page yang persuasif dan profesional menggunakan AI.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        :root {
            --bg: #0a0a0f;
            --text: #fdfaf5;
            --muted: #a0a0ab;
            --accent: #6366f1;
            --accent-light: #818cf8;
            --border: rgba(99, 102, 241, 0.2);
            --surface: rgba(255, 255, 255, 0.03);
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            background-image:
                radial-gradient(ellipse at 50% -10%, rgba(99, 102, 241, 0.3) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%);
        }

        /* Nav */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            padding: 20px 0;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(10, 10, 15, 0.8);
        }

        .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #818cf8, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            letter-spacing: -0.02em;
        }

        .nav-links {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-nav-ghost {
            padding: 10px 20px;
            border-radius: 10px;
            border: 1px solid var(--border);
            color: var(--text);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-nav-ghost:hover {
            border-color: var(--accent-light);
            color: var(--accent-light);
        }

        .btn-nav-primary {
            padding: 10px 20px;
            border-radius: 10px;
            background: var(--accent);
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-nav-primary:hover {
            background: var(--accent-light);
            transform: translateY(-1px);
        }

        /* Hero */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 24px 80px;
        }

        .hero-inner {
            max-width: 800px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 0.8rem;
            color: var(--accent-light);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 32px;
            animation: fadeUp 0.6s ease forwards;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            background: var(--accent-light);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0.4
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        h1 {
            font-size: clamp(2.8rem, 7vw, 5.5rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.04em;
            margin-bottom: 24px;
            animation: fadeUp 0.6s 0.1s ease both;
        }

        .gradient-text {
            background: linear-gradient(135deg, #818cf8 0%, #c4b5fd 50%, #f9a8d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: var(--muted);
            max-width: 560px;
            margin: 0 auto 40px;
            line-height: 1.8;
            animation: fadeUp 0.6s 0.2s ease both;
        }

        .hero-ctas {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeUp 0.6s 0.3s ease both;
        }

        .btn-primary-lg {
            padding: 16px 36px;
            border-radius: 12px;
            background: var(--accent);
            color: white;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 0 40px rgba(99, 102, 241, 0.3);
        }

        .btn-primary-lg:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 0 60px rgba(99, 102, 241, 0.5);
        }

        .btn-ghost-lg {
            padding: 16px 36px;
            border-radius: 12px;
            border: 1px solid var(--border);
            color: var(--text);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-ghost-lg:hover {
            border-color: var(--accent-light);
            background: var(--surface);
        }

        /* Social proof */
        .social-proof {
            margin-top: 60px;
            display: flex;
            gap: 32px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            animation: fadeUp 0.6s 0.4s ease both;
        }

        .social-proof p {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .divider {
            width: 1px;
            height: 20px;
            background: var(--border);
        }

        /* How it works */
        .section {
            padding: 100px 24px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--accent-light);
            text-align: center;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            text-align: center;
            margin-bottom: 16px;
        }

        .section-sub {
            text-align: center;
            color: var(--muted);
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 64px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        .step-card {
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 40px 32px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .step-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .step-card:hover::before {
            transform: scaleX(1);
        }

        .step-card:hover {
            border-color: var(--border);
            transform: translateY(-4px);
        }

        .step-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--accent);
            opacity: 0.3;
            margin-bottom: 16px;
            line-height: 1;
        }

        .step-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .step-card p {
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 28px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            border-color: var(--border);
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 16px;
        }

        .feature-card h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .feature-card p {
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            padding: 80px 24px;
            text-align: center;
        }

        .cta-card {
            max-width: 700px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 80px 60px;
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 60%);
        }

        .cta-card h2 {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 16px;
            position: relative;
        }

        .cta-card p {
            color: var(--muted);
            font-size: 1.1rem;
            margin-bottom: 40px;
            position: relative;
        }

        /* Footer */
        footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 32px 24px;
            text-align: center;
        }

        footer p {
            color: var(--muted);
            font-size: 0.85rem;
        }

        footer a {
            color: var(--accent-light);
            text-decoration: none;
        }

        @media (max-width: 640px) {
            .nav-links .btn-nav-ghost {
                display: none;
            }

            .divider {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- Nav --}}
    <nav>
        <div class="nav-inner">
            <a href="/" class="logo">✦ SalesAI</a>
            <div class="nav-links">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav-primary">Dashboard →</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav-ghost">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-nav-primary">Mulai Gratis</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="hero">
        <div class="hero-inner">
            <div class="badge">
                <span class="badge-dot"></span>
                Powered by Google Gemini AI
            </div>
            <h1>
                Ubah Produkmu Jadi<br>
                <span class="gradient-text">Sales Page yang Menjual</span>
            </h1>
            <p>Isi informasi produk, dan biarkan AI membuatkan sales page yang persuasif, profesional, dan siap publish
                — dalam hitungan detik.</p>
            <div class="hero-ctas">
                <a href="{{ route('register') }}" class="btn-primary-lg">✨ Coba Gratis Sekarang</a>
                <a href="{{ route('login') }}" class="btn-ghost-lg">Sudah punya akun →</a>
            </div>
            <div class="social-proof">
                <p>🔒 Tidak perlu kartu kredit</p>
                <div class="divider"></div>
                <p>⚡ Generate dalam 30 detik</p>
                <div class="divider"></div>
                <p>📄 Export sebagai HTML</p>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <div style="max-width:1100px;margin:0 auto;padding:0 24px">
        <div style="border-top:1px solid rgba(255,255,255,0.05)"></div>
    </div>
    <section class="section">
        <p class="section-label">Cara Kerja</p>
        <h2 class="section-title">3 Langkah, Sales Page Siap</h2>
        <p class="section-sub">Tidak perlu skill desain atau copywriting. AI mengurus semuanya.</p>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">01</div>
                <h3>Isi Informasi Produk</h3>
                <p>Masukkan nama produk, deskripsi, fitur, target audience, harga, dan keunggulan unikmu.</p>
            </div>
            <div class="step-card">
                <div class="step-number">02</div>
                <h3>AI Generate Sales Page</h3>
                <p>Gemini AI menganalisis datamu dan menghasilkan sales page lengkap dengan copywriting yang persuasif.
                </p>
            </div>
            <div class="step-card">
                <div class="step-number">03</div>
                <h3>Preview & Export</h3>
                <p>Lihat hasil langsung sebagai live preview. Export sebagai file HTML siap publish ke mana saja.</p>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="section" style="padding-top:0">
        <p class="section-label">Fitur</p>
        <h2 class="section-title">Semua yang Kamu Butuhkan</h2>
        <p class="section-sub">Dibangun untuk pemilik bisnis yang ingin bergerak cepat.</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <h3>AI-Powered Copy</h3>
                <p>Headline, benefit section, social proof, hingga CTA — semua ditulis oleh AI dengan tone persuasif.
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👁️</div>
                <h3>Live Preview</h3>
                <p>Lihat hasil generate langsung sebagai halaman web yang bisa di-scroll — bukan plain text.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⬇️</div>
                <h3>Export HTML</h3>
                <p>Download sales page sebagai file HTML standalone yang bisa langsung diupload ke hosting manapun.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h3>Generate Ulang</h3>
                <p>Tidak puas dengan hasilnya? Generate ulang untuk mendapatkan variasi copywriting yang berbeda.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <h3>History Tersimpan</h3>
                <p>Semua sales page tersimpan di akun kamu. Akses, edit, atau hapus kapan saja.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Content Moderation</h3>
                <p>Sistem moderasi otomatis memastikan semua konten yang digenerate sesuai kebijakan halal.</p>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="cta-card">
            <h2>Siap Buat Sales Page<br><span class="gradient-text">Pertamamu?</span></h2>
            <p>Gratis. Tidak perlu kartu kredit. Mulai dalam 30 detik.</p>
            <a href="{{ route('register') }}" class="btn-primary-lg">
                ✨ Mulai Gratis Sekarang
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer>
        <p>© {{ date('Y') }} SalesAI, Created with &hearts; by <a
                href="https://linkedin.com/in/radja-ravine-salfriandry">Radja Ravine Salfriandry</a></p>
    </footer>

</body>

</html>
