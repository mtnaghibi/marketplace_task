<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class StoreAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $errorMessage = 'Please, complete store data!';
        try {
            $store = Auth::user()->store;
            //If seller complete store's information, send to next request.
            if ($store)
                return $next($request);
            return $this->incomplete($errorMessage);
        } catch (JWTException $e) {
            //Thrown if token was not found in the request.
            return $this->incomplete($errorMessage);
        }

    }

    /**
     * throw Exception
     * @param null $message
     */
    private function incomplete($message = null)
    {
        throw new ModelNotFoundException($message);
    }
}
