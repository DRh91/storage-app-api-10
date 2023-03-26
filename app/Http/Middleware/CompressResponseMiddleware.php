<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompressResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $compressed = $request->input('compressed') === 'true' ?? false;
        if (!$compressed) {
            return $response;
        }

        if (in_array('gzip', $request->getEncodings()) && function_exists('gzencode')) {
            $response->setContent(gzencode($response->getContent()));
        }

        return $response;
    }
}
