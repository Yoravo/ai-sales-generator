<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\SalesPage;
use App\Services\GeminiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateSalesPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public int $tries = 0;
    public int $timeout = 120;
    public int $backoff = 10;

    public function __construct(
        private readonly SalesPage $salesPage
    ) {}

    public function handle(GeminiService $geminiService): void
    {
        try {
            $generatedHtml = $geminiService->generateSalesPage(
                $this->salesPage->toArray()
            );

            $this->salesPage->update([
                'generated_html' => $generatedHtml,
                'status'         => 'generated',
            ]);
        } catch (\Throwable $e) {
            $this->salesPage->update(['status' => 'failed']);

            Log::error('GenerateSalesPageJob failed', [
                'sales_page_id' => $this->salesPage->id,
                'error'         => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $e): void
    {
        $this->salesPage->update(['status' => 'failed']);

        Log::error('GenerateSalesPageJob permanently failed', [
            'sales_page_id' => $this->salesPage->id,
            'error'         => $e->getMessage(),
        ]);
    }
}