<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Número (hash corto) del último commit, sin enlace, para el pie de página.
        View::composer('layouts.app', function ($view) {
            $version = Cache::remember('app.version', 30, function () {
                $out = @shell_exec('git -C '.escapeshellarg(base_path()).' rev-parse --short HEAD 2>/dev/null');

                return trim((string) $out) ?: 'dev';
            });
            $view->with('version', $version);
        });
    }
}
