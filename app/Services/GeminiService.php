<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class GeminiService
{
    private string $apiKey;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->apiUrl = config('services.gemini.url');
    }

    public function generateSalesPage(array $productData): string
    {
        $prompt = $this->buildPrompt($productData);

        $response = Http::timeout(120)->post("{$this->apiUrl}?key={$this->apiKey}", [
            'contents' => [
                [
                    'parts' => [['text' => $prompt]],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.8,
                'maxOutputTokens' => 65536,
                'stopSequences' => [],
            ],
        ]);

        if ($response->failed()) {
            Log::error('Gemini API error', ['response' => $response->body()]);
            throw new Exception('Gagal menghubungi Gemini API: ' . $response->status());
        }

        $data = $response->json();

        // Cek finish reason — kalau MAX_TOKENS berarti masih terpotong
        $finishReason = $data['candidates'][0]['finishReason'] ?? null;
        if ($finishReason === 'MAX_TOKENS') {
            throw new Exception('Output AI terpotong. Coba generate ulang.');
        }

        $generatedText = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$generatedText) {
            throw new Exception('Gemini tidak mengembalikan konten.');
        }

        // Bersihkan markdown code block kalau ada
        $generatedText = preg_replace('/^```html\s*/i', '', $generatedText);
        $generatedText = preg_replace('/\s*```$/m', '', $generatedText);

        // Validasi output adalah HTML valid (minimal ada tag penutup)
        if (!str_contains($generatedText, '</html>')) {
            throw new Exception('Output HTML tidak lengkap. Coba generate ulang.');
        }

        return trim($generatedText);
    }

    private function buildPrompt(array $data): string
    {
        $features = is_array($data['features']) ? implode(', ', $data['features']) : $data['features'];

        return <<<PROMPT
        You are a world-class UI/UX designer and conversion copywriter — think Stripe, Linear, or Vercel landing pages level of craft. Your job is to generate a complete, stunning, high-converting sales page in a single HTML file.

        ## Product Information
        - Product Name: {$data['product_name']}
        - Description: {$data['description']}
        - Key Features: {$features}
        - Target Audience: {$data['target_audience']}
        - Price: {$data['price']}
        - Unique Selling Point: {$data['unique_selling_point']}

        ## Output Rules
        1. Return ONLY raw HTML — zero markdown, zero code fences, zero explanation text
        2. Single self-contained file — all CSS in <style>, all JS in <script>
        3. DO NOT use Tailwind CDN or any CSS framework — write all styles from scratch using CSS variables and modern CSS
        4. Start with <!DOCTYPE html> and a complete <head> with meta charset, viewport, title, and description

        ## Typography Rules
        - Import 2 fonts from Google Fonts: one distinctive DISPLAY font for headlines (e.g. Playfair Display, Fraunces, DM Serif Display, Cormorant Garamond, Syne, Cabinet Grotesk — pick one that matches the product's personality), and one clean BODY font (e.g. DM Sans, Plus Jakarta Sans, Outfit, Figtree — NOT Inter, NOT Roboto, NOT Arial)
        - Headlines: large, bold, tight letter-spacing, commanding presence
        - Body: comfortable line-height (1.6-1.8), optimal measure (60-75 chars per line)
        - Use fluid typography with clamp() for responsive sizing
        - Font size scale: maintain clear hierarchy with at least 5 distinct levels

        ## Color & Theme Rules
        - Define all colors as CSS custom properties (--color-*) at :root
        - Choose ONE of these aesthetic directions based on the product's personality:
          a) DARK LUXURY: Deep charcoal/obsidian background (#0a0a0f), warm cream text, single gold or copper accent
          b) LIGHT EDITORIAL: Off-white (#fafaf8) background, near-black text, one vivid accent (electric blue, terracotta, or forest green)
          c) BOLD MODERN: White background, pure black text, ONE loud accent color (not purple/indigo — try coral, amber, electric green, or cobalt)
        - Use the accent color SPARINGLY — only for CTAs, highlights, and key moments
        - NEVER use generic purple/indigo gradients on white — this is the #1 AI-slop tell
        - Backgrounds must have atmosphere: subtle noise texture, gradient mesh, or geometric pattern — never flat solid white

        ## Layout & Spatial Rules
        - Use CSS Grid and Flexbox — no tables, no floats
        - Create visual tension: mix wide full-bleed sections with contained narrow content
        - Use asymmetry deliberately — not everything centered
        - Generous whitespace between sections (min 120px padding top/bottom)
        - Max content width: 1100px centered with auto margins
        - At least one "grid-breaking" element — a card, image, or stat that overlaps sections or breaks the column

        ## Animation & Motion Rules
        - Add a smooth page load: use @keyframes + animation-delay for staggered hero reveal (headline → subheadline → CTA, each delayed 150ms)
        - Scroll-triggered fade-in for sections below the fold using IntersectionObserver
        - Hover states on all interactive elements: CTA button (scale + shadow), cards (translateY(-4px)), links (underline slide)
        - One signature animation: floating/pulsing effect on the hero badge or accent element
        - All transitions: cubic-bezier(0.16, 1, 0.3, 1) for natural easing

        ## Sections Required (in this order)
        1. **NAV** — Logo (product name) left, one CTA button right. Sticky with backdrop-filter blur on scroll.
        2. **HERO** — Badge/pill label ("Introducing..." or category tag), massive headline (2–3 lines), sub-headline, 2 CTA buttons (primary + secondary ghost), social proof micro-copy (e.g. "Dipercaya 500+ bisnis"), hero visual (use a CSS-only abstract shape, gradient blob, or geometric pattern — no placeholder images)
        3. **SOCIAL PROOF BAR** — Full-width strip with 3-4 stats/numbers (e.g. "500+ Pengguna", "4.9★ Rating", "Rp 2M+ Revenue Dihasilkan"). High contrast background.
        4. **PROBLEM → SOLUTION** — 2-column layout. Left: identify the pain point your target audience feels. Right: position the product as the elegant solution.
        5. **BENEFITS** — 3 key benefits. Use an unexpected layout (e.g. large numbered list, horizontal scroll cards, or diagonal grid — NOT a standard 3-column icon grid)
        6. **FEATURES** — Feature breakdown for: {$features}. Use a tabbed interface OR alternating 2-column rows (text left + visual right, then flip) — NOT a plain bullet list
        7. **TESTIMONIALS** — 3 cards with placeholder names (Indonesian names), role, company, and a 1-2 sentence quote. Cards with subtle border, soft shadow.
        8. **PRICING** — Clean pricing card for: {$data['price']}. Include what's included (list), a "most popular" badge if appropriate, and the CTA button. Add urgency copy if relevant.
        9. **FAQ** — 4 accordion items (CSS-only accordion with <details>/<summary>) addressing common objections.
        10. **FINAL CTA** — Full-width section, high contrast background (use accent color or dark), large headline, subtext, and prominent button.
        11. **FOOTER** — Product name, tagline, copyright. Minimal.

        ## Copywriting Rules
        - All copy in Bahasa Indonesia — natural, conversational, NOT stiff corporate language
        - Headlines: use power words, numbers, and specificity ("Bukan template biasa — ini mesin konversi")
        - Benefits copy: focus on outcomes, not features ("Hemat 10 jam/minggu" not "Fitur otomatis")
        - CTA buttons: action-oriented and specific ("Mulai Gratis Sekarang", "Lihat Demo", "Saya Mau Coba")
        - Avoid filler phrases: "solusi terbaik", "platform canggih", "terpercaya" — be specific
        - Social proof numbers must feel real and achievable, not exaggerated
        - NO generic placeholder text like "Lorem ipsum" or "Coming soon"

        ## Anti-AI-Slop Checklist
        - ❌ NO purple/indigo gradient on white background
        - ❌ NO standard 3-column feature card grid with emoji icons
        - ❌ NO Inter/Roboto/Arial fonts
        - ❌ NO centered everything layout
        - ❌ NO flat solid white background with no texture or depth
        - ❌ NO generic "rocket ship" or "sparkle" emojis as the main visual
        - ❌ NO lorem ipsum or obviously fake placeholder content
        - ✅ YES to distinctive typography pairing
        - ✅ YES to one unexpected layout moment that makes someone stop scrolling
        - ✅ YES to real atmospheric depth in the background
        - ✅ YES to copy that sounds like a real human wrote it
        PROMPT;
    }
}