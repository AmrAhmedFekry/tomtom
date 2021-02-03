<?php
namespace App\Modules\Buyers\Traits\Auth;

use Illuminate\Support\Str;

trait AccessToken
{
    /**
     * Generate new access token to the given user model
     *
     * @param  \App\Modules\Buyers\Models\Buyer $buyer
     * @param  |Illuminate\Http\Request $request
     * @return string
     */
    public function generateAccessToken($buyer, $request)
    {
        $accessToken = Str::random(96);

        $token = [
            'token' => $accessToken,
        ];

        if (empty($buyer->accessTokens)) {
            $buyer->accessTokens = [$token];
        } else {
            $accessTokens = $buyer->accessTokens;
            array_push($accessTokens, $token);
            $buyer->accessTokens = $accessTokens;
        }

        $buyer->save();

        return $accessToken;
    }

    /**
     * Get user model by access token
     *
     * @param  string $accessToken
     * @return \App\Modules\Buyers\Models\Buyer
     */
    public function getByAccessToken(string $accessToken)
    {
        $model = static::MODEL;

        $buyer =  $model::where('accessTokens.token', $accessToken)->first();

        return $buyer ?: null;
    }
}
