<?php

namespace App\Http\Middleware\Api;

use App\Exceptions\AuthException;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserEmailIsNotVerify
{
    use JsonAPIMessages;
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (auth()->guard('api')->check() && !auth()->guard('api')->user()->email_verified_at) {
                throw new AuthException(__('You must verify your email address to access this page.'), HttpStatusCode::FORBIDDEN->value);
            }
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        }
        return $next($request);
    }
}
