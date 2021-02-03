<?php
namespace App\Modules\Buyers\Controllers\Site\Auth;

use Illuminate\Http\Request;
use HZ\Illuminate\Mongez\Managers\ApiController;

class ResetPasswordController extends ApiController
{
    /**
     * Verify user code
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $castRepository = repo('casts');
        $cast = $castRepository->getBy('email', $request->email);

        if (! $cast || $cast->resource->code != $request->code) {
            return $this->badRequest([
                'errors' => [
                    'Invalid code or email'
                ]
            ]);
        }

        $cast = $cast->resource;

        unset($cast->code);

        $cast->updatePassword($request->password);

        $accessToken = $castRepository->generateAccessToken($cast, $request);

        $castInfo = $castRepository->wrap($cast)->toArray($request);

        $castInfo['accessToken'] = $accessToken;

        return $this->success([
            'cast' => $castInfo,
        ]);
    }
}
