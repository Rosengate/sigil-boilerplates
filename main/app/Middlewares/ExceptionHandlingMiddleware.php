<?php

namespace App\Middlewares;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ExceptionHandlingMiddleware
{
    public function handle(Request $request, $next)
    {
        try {
            return $next($request);
        } catch (ModelNotFoundException $e) {
            return new Response([
                'error' => [
                    'exception' => 'ResourceNotFoundException',
                    'message' => 'Resource not found'
                ]
            ], 404);
        } catch (\Exception $e) {
            $exception = explode("\\", $e::class);

            return new Response([
                'error' => [
                    'exception' => $code = array_pop($exception),
                    'message' => $e->getMessage() ? $e->getMessage() : $code
                ]
            ], 400);
        }
    }
}
