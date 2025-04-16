<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Response::macro('success', function (array|null $data = null, string $message) {
            return Response::json([
                'success'  => true,
                'message' => $message,
                'data' => $data,
              ], 200);
        });

        Response::macro('error', function (string $message, int $errorCode = 400) {
            return Response::json([
                'success'  => false,
                'message' => $message,
                'data' => null,
              ], $errorCode);
        });
    }
}
