<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Los URI que deben ser excluidos de la verificación CSRF.
     *
     * @var array
     */
    protected $except = [
        '*',
    ];
}
