<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\GenerateSalesPageJob;
use App\Models\SalesPage;
use App\Services\ContentModerationService;
use App\Services\GeminiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class SalesPageController extends Controller
{
    public function __construct(private readonly GeminiService $geminiService, private readonly ContentModerationService $moderationService) {}

    public function create(): View
    {
        return view('sales-pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|string',
            'target_audience' => 'required|string|max:255',
            'price' => 'required|string|max:100',
            'unique_selling_point' => 'required|string',
        ]);

        // ← Moderation check SEBELUM apapun
        if (!$this->moderationService->passes($validated)) {
            return back()
                ->withInput()
                ->withErrors([
                    'product_name' => '🚫 Produk tidak dapat diproses. Pastikan konten sesuai dengan kebijakan penggunaan kami.',
                ]);
        }

        $validated['features'] = array_map('trim', explode(',', $validated['features']));
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'processing';

        $salesPage = SalesPage::create($validated);

        GenerateSalesPageJob::dispatch($salesPage);

        return redirect()->route('sales-pages.show', $salesPage)->with('success', '⚡ Sales page sedang digenerate di background!');
    }

    public function regenerate(SalesPage $salesPage): RedirectResponse
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);

        $salesPage->update(['status' => 'processing']);
        GenerateSalesPageJob::dispatch($salesPage);

        return redirect()->route('sales-pages.show', $salesPage)->with('success', '🔄 Generate ulang sedang diproses!');
    }

    public function export(SalesPage $salesPage): \Illuminate\Http\Response
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);
        abort_if($salesPage->status !== 'generated', 404);

        $filename = str($salesPage->product_name)->slug() . '-sales-page.html';

        return response($salesPage->generated_html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function preview(SalesPage $salesPage): \Illuminate\Http\Response
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);
        abort_if(!$salesPage->generated_html, 404);

        return response($salesPage->generated_html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'X-Frame-Options' => 'SAMEORIGIN',
        ]);
    }

    public function index(): View
    {
        $salesPages = SalesPage::where('user_id', Auth::id())->when(request('search'), fn($q, $search) => $q->where('product_name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%"))->latest()->paginate(10);

        return view('sales-pages.index', compact('salesPages'));
    }

    public function show(SalesPage $salesPage): View
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);

        return view('sales-pages.show', compact('salesPage'));
    }

    public function destroy(SalesPage $salesPage): RedirectResponse
    {
        abort_if($salesPage->user_id !== Auth::id(), 403);
        $salesPage->delete();

        return redirect()->route('sales-pages.index')->with('success', 'Sales page berhasil dihapus.');
    }
}