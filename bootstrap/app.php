<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__ . '/../routes/web.php', commands: __DIR__ . '/../routes/console.php', health: '/up')
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Terlalu banyak request. Coba lagi dalam 1 menit.'], 429);
            }
            return back()->withErrors(['product_name' => '⏳ Terlalu banyak request. Tunggu 1 menit sebelum generate lagi.']);
        });
    })
    ->create();