<?php
namespace App\Modules\Buyers\Middleware;

use Closure;
use Auth as BaseAuth;
use Illuminate\Http\Request;

class LoggedIn
{
    /**
     * {@inheritDoc}
     */
    public function handle(Request $request, Closure $next)
    {
        if (user('buyer')) return $next($request);

        $accessToken = $request->authorizationValue();

        $repositoryName = config('app.users-repo');

        $user = repo($repositoryName)->getByAccessToken($accessToken);

        if ($user) {
            BaseAuth::login($user);

            return $next($request);
        } else {
            return response('Invalid Request', 400);
        }
    }
}
