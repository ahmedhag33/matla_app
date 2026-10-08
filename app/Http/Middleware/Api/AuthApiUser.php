<?php

namespace App\Http\Middleware\Api;

use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiUser
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
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->errorException(HttpStatusCode::UNAUTHORIZED->value, __('Token is Invalid'));
            } else if ($e instanceof TokenExpiredException) {
                return $this->errorException(HttpStatusCode::UNAUTHORIZED->value, __('Token is Expired'));
            } else {
                return $this->errorException(HttpStatusCode::UNAUTHORIZED->value, __('Authorization Token not found'));
            }
        }
        return $next($request);
    }
}
