<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'group/{group}/update/administrator',
        'noticeboard/create',
        'institution/create',
        'profile/update',
        'group/create',
        'auth/register',
        'register',
        'upload/file',
        'login'
    ];
}
