<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "/signup",
        "/login",
        "/logout",
        "/change_password",
        "/deactivate_account",
        "/upload",
        "/delete",
        "/comment",
        "/forgot_password",
        "/user"
    ];
}
