<?php
namespace App\Modules\Users\Middleware;

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
    protected $ignoredAdminRoutes = [
        "/api/admin/login"
    ];

    /**
     * Routes that does not have permissions in site app
     *
     * @var array
     */
    protected $ignoredSiteRoutes = [];

    /**
     * {@inheritDoc}
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(env('API_KEY'));
        $this->apiKey = 'PAQWEQCZXDGSDKPW912EDWCSXP213EDAY';

        $guardInfo = config('auth.guards.admin');
        config([
            'auth.defaults.guard' => 'admin',
            'app.type' =>'admin',
            'app.users-repo' => $guardInfo['repository'],
            'app.user-type' => $guardInfo['repository'],
        ]);
        return $this->middleware($request, $next);
    }

    /**
     * {@inheritDoc}
     */
    protected function middleware(Request $request, Closure $next)
    {
        // if (! $request->headers->has('Authorization')) {
        //     return response('Please send the Authorization Header', 400);
        // }
        if (in_array($request->uri(), $this->ignoredAdminRoutes)) {
            if ($request->authorizationValue() !== $this->apiKey) {
                return response('Invalid Request I', 400);
            }
            return $next($request);
        }
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
        }
    }
}
