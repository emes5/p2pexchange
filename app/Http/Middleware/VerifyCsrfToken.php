<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'user/g2f-secret-save',
        'user/withdrawal-coin/callback',
        'user/withdrawal-coin/deposit/callback',
        'user/withdrawal-coin/cancel-withdrawal',
        'user/report-user-order',
        'user/update-feedback',
        'user/cancel-trade',
        'user/upload-payment-sleep'
    ];
}
