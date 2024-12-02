<?php

namespace App\Http\Middleware;

use App\User;
use Carbon\Carbon;
use Closure;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;

class AutenticacaoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::user();
            $user= User::find($userId->id);

            if ($user && $user->last_reset_income_today !== Carbon::now()->toDateString()) {
                $user->incomeToday = 0;
                $user->last_reset_income_today = Carbon::now()->toDateString();
                $user->save();
            }

            return $next($request);
        }

        return redirect()->route('site.login', ['error' => 2]);
    }
}
