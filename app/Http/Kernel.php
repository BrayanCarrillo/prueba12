
protected $middleware = [
    // Otros middlewares...
    \App\Http\Middleware\CorsMiddleware::class,
    \App\Http\Middleware\VerifyCsrfToken::class,
    \App\Http\Middleware\Cors::class,
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

