<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class ContentModerationService
{
    private const PROHIBITED = ['alkohol', 'alcohol', 'beer', 'wine', 'bir', 'miras', 'rokok', 'tobacco', 'vape', 'cannabis', 'ganja', 'narkoba', 'judi', 'gambling', 'casino', 'togel', 'slot', 'poker', 'taruhan', 'porn', 'adult', 'escort', 'bokep', 'ponzi', 'money game', 'skema piramid', 'senjata', 'weapon', 'pistol'];

    public function __construct(private readonly string $apiKey, private readonly string $apiUrl) {}

    public function passes(array $data): bool
    {
        // layer 1 keyword filter (0 API calls)
        $text = strtolower(implode(' ', [$data['product_name'] ?? '', $data['description'] ?? '', $data['unique_selling_point'] ?? '']));

        foreach (self::PROHIBITED as $keyword) {
            if (str_contains($text, $keyword)) {
                Log::info('Moderation Layer 1 failed', ['keyword' => $keyword]);
                return false;
            }
        }
        // direct to layer 2 filter - AI Check for obfuscated text like jud1, r0k0k, etc.
        return $this->aiCheck($data);
    }

    public function aiCheck(array $data): bool
    {
        $text = implode(' | ', [
            $data['product_name']         ?? '',
            $data['description']          ?? '',
            $data['unique_selling_point'] ?? '',
        ]);

        try {
            $response = Http::timeout(15)->post("{$this->apiUrl}?key={$this->apiKey}", [
                'contents' => [[
                    'parts' => [[
                        'text' => <<<PROMPT
                        You are a content moderator. Analyze this product submission and reply with ONLY one word: PASS or FAIL.

                        FAIL if the product involves: alcohol, gambling, adult/porn content, tobacco, drugs, weapons, pyramid schemes, scams, or anything haram in Islam — even if words are obfuscated (e.g. "jud1", "r0k0k", "g4mbling").

                        PASS if the product is a legitimate halal business.

                        Product: {$text}

                        Reply with ONLY one word: PASS or FAIL
                        PROMPT
                    ]]
                ]],
                'generationConfig' => [
                    'temperature'     => 0,
                    'maxOutputTokens' => 5,
                ]
            ]);

            if ($response->failed()) {
                Log::warning('Moderation L2 API failed, defaulting to PASS');
                return true;
            }

            $result = strtoupper(trim(
                $response->json('candidates.0.content.parts.0.text') ?? 'PASS'
            ));

            Log::info('Moderation L2 result', ['result' => $result]);

            return str_contains($result, 'PASS');

        } catch (\Throwable $e) {
            Log::warning('Moderation L2 exception', ['error' => $e->getMessage()]);
            return true;
        }
    }
}