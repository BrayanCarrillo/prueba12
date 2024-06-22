protected $middleware = [
    // Otros middleware...
    \App\Http\Middleware\CorsMiddleware::class,
];

protected $middlewareGroups = [
    'web' => [
        // Otros middlewares...
        \App\Http\Middleware\VerifyCsrfToken::class,
    ],

    'api' => [
        // Otros middlewares...
        \App\Http\Middleware\VerifyCsrfToken::class,
    ],
];
