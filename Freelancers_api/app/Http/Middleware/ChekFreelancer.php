<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChekFreelancer
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role->name != 'freelancer') {
                return response()->json([
                    'success' => false,
                    'message' => 'action non autorisé',
                ], 403);
            }
            return $next($request);  
    }
}
