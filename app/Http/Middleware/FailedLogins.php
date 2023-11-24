<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class FailedLogins extends ThrottleRequests
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = ''): Response
    {
        $response = $next($request);

        if ($this->shouldThrottle()) {
            $response = $this->rateLimitRequest($request, $next, $maxAttempts, $decayMinutes);
        }

        return $response;
    }

    public function isLoginSuccessful(): bool
    {
        return Auth::check();
    }

    public function shouldThrottle(): bool
    {
        return !$this->isLoginSuccessful();
    }

    protected function rateLimitRequest(
        Request    $request,
        Closure    $next,
        int|string $maxAttempts,
        int|float  $decayMinutes
    ): Response
    {
        return parent::handle($request, $next, $maxAttempts, $decayMinutes);
    }
}
