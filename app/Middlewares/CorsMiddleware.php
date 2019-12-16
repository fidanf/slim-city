<?php

namespace App\Middlewares;

use Slim\Http\{Request, Response};

class CorsMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $response = $next($request, $response);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'Request, X-Requested-With, Content-Type, Accept, Origin, Authorization');
    }
}