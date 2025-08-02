<?php

//use Illuminate\Foundation\Application
use Gecche\Multidomain\Foundation\Application;
use App\Http\Middleware\InjectFinancialYearDates;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$environmentPath = null;
$domainParams = [
    'domain_detection_function_web' => function () {
        return \Illuminate\Support\Arr::get($_SERVER, 'HTTP_HOST');
    }
];

return Application::configure(
    basePath: dirname(__DIR__),
    environmentPath: $environmentPath,
    domainParams: $domainParams
)
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->web(append: [
            InjectFinancialYearDates::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
