<?php declare(strict_types=1);



namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

final class ApprovalMiddleware
{
    /**
     *
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (auth()->check()) {
            if (! auth()->user()->approved_at) {
                Auth::guard('web')->logout();

                return redirect()->route('login')->with('message', 'Sorry but your account needs approvel');
            }
        }

        return $next($request);
    }
}
