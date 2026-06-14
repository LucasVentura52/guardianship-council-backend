<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfAuthenticated { public function handle($request, Closure $next, ...$guards) { foreach ($guards as $guard) { if (Auth::guard($guard)->check()) return response()->json(['message' => 'Já autenticado.'], 409); } return $next($request); } }
