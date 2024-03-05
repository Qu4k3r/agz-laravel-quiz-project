<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use LaravelDoctrine\ORM\Facades\EntityManager;
use \Symfony\Component\HttpFoundation\Response as HttpStatus;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function (array $data = [], string $message = null, int $statusCode = HttpStatus::HTTP_OK) {
            EntityManager::flush();
            return $message ?
                response()->json
                (
                    [
                        'success' => true,
                        'data' => $data,
                        'message' => $message,
                    ],
                    $statusCode
                ) :
                response()->json
                (
                    [
                        'success' => true,
                        'data' => $data,
                    ],
                    $statusCode
                );
        });

        Response::macro('successWithoutFlush', function (array $data = [], string $message = null, int $statusCode = HttpStatus::HTTP_OK) {
            return $message ?
                response()->json
                (
                    [
                        'success' => true,
                        'data' => $data,
                        'message' => $message,
                    ],
                    $statusCode
                ) :
                response()->json
                (
                    [
                        'success' => true,
                        'data' => $data,
                    ],
                    $statusCode
                );
        });

        Response::macro('error', function (string $message, int $statusCode = HttpStatus::HTTP_BAD_REQUEST) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        });
    }
}
