<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 419) {
                return back()->with(['error' => 'The page expired, Please try again.']);
            }elseif($response->getStatusCode() === 405){
                \Illuminate\Support\Facades\Log::warning('Method Not Allowed (405)', [
                    'url' => request()->fullUrl(),
                    'method' => request()->method(),
                    'body' => request()->all(),
                ]);
                return back()->with(['error' => 'Invalid Request, Please try again.']);
            }
            return $response;
        });
    })->create();
