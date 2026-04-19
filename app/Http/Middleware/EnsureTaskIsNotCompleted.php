<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTaskIsNotCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->route('task')->is_completed) {
            return response()->json(['message' => 'Cannot modify a completed task.'], 400);
        }
        
        return $next($request);
    }
}
