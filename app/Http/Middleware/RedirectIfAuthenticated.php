<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admins.dashboard');
                }
                break;
            case 'company':
                if (Auth::guard($guard)->check()) {
                    $exists = DB::table('companies')
                        ->where('com_user_id', Auth::guard('company')->user()->getAuthIdentifier())
                        ->exists();

                    if ($exists) {
                        return redirect()->route('companies.home');
                    } else {
                        return redirect()->route('companies.showCreate');
                    }
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/');
                }
                break;
        }
        return $next($request);
    }
}
