<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SalesPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $stats = [
            'total'     => SalesPage::where('user_id', $userId)->count(),
            'generated' => SalesPage::where('user_id', $userId)
                                ->where('status', 'generated')->count(),
            'this_month'=> SalesPage::where('user_id', $userId)
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count(),
            'failed'    => SalesPage::where('user_id', $userId)
                                ->where('status', 'failed')->count(),
        ];

        $recents = SalesPage::where('user_id', $userId)
            ->latest()
            ->limit(3)
            ->get();

        return view('dashboard', compact('stats', 'recents'));
    }
}