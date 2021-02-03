<?php
namespace App\Modules\Buyers\Controllers\Site\Auth;

use Closure;
use Auth as BaseAuth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Auth
{
    /**
     * Application key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Application type
     *
     * @var string
     */
    protected $appType;

    /**
     * Routes that does not have permissions in admin app
     *
     * @var array
     */
    protected $ignoredAdminRoutes = ["/api/admin/login"];

    /**
     * Routes that does not have permissions in site app
     *
     * @var array
     */
    protected $ignoredSiteRoutes = [];


    /**
     * Routes that does not have permissions in admin app
     *
     * @var array
     */
    protected $ignoredRoutes = [];

    /**
     * {@inheritDoc}
     */
    public function handle(Request $request, Closure $next)
    {
        $this->apiKey = env('API_KEY');
        list($tokenType) = $request->authorization();
        $requestUri = preg_replace('/([\d])+/', "{id}", preg_quote($request->uri()));

        // set default auth
        if (Str::contains($request->uri(), '/admin')) {
            $this->appType = 'admin';
        } else {
            $this->appType = 'cast';
        }

        $accountType =  $request->header('accountType');
        if (! $request->headers->has('accountType')) {
            $accountType = 'buyer';
        }
        $guardInfo = config('auth.guards.' .$accountType);

        if ($tokenType == 'Bearer') {
            config([
                'auth.defaults.guard' => $accountType,
                'app.type' => $accountType,
                'app.users-repo' => $guardInfo['repository'],
                'app.user-type' => $guardInfo['repository'],
            ]);

            return $this->middleware($request, $next);
        }

        if (in_array($requestUri, $this->ignoredRoutes)) {
            if ($request->authorizationValue() !== $this->apiKey) {
                return response('Invalid Request I', 400);
            }
            return $next($request);
        }

    }

    /**
     * {@inheritDoc}
     */
    protected function middleware(Request $request, Closure $next)
    {
        $ignoredRoutes = $this->appType == 'admin' ? $this->ignoredAdminRoutes : $this->ignoredSiteRoutes;
        if (in_array($request->uri(), $ignoredRoutes)) {
            if ($request->authorizationValue() !== $this->apiKey) {
                return response('Invalid Request I', 400);
            }
            return $next($request);
        } else {
            // validate if and only if the authorization access token is sent
            list($tokenType, $accessToken) = $request->authorization();
            if ($tokenType == 'Bearer') {
                $user = repo(config('app.users-repo'))->getByAccessToken($accessToken);
                if ($user) {
                    BaseAuth::login($user);

                    return $next($request);
                } else {
                    return response('Invalid Request II', 400);
                }
            } else {
                if ($accessToken != $this->apiKey) {
                    return response('Invalid Request III', 400);
                }
                return $next($request);
            }
        }
    }
}
