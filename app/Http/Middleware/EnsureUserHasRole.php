<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if($request->user()->role()->where('name',$role)->first())
        {
            return $next($request);
        }else{
            return FacadesResponse::json([
                'status' => false,
                'message' => "not authorized to access ".$role." Data"
            ],401);
        }
    }
}
