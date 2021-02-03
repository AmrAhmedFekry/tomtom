<?php
namespace App\Modules\Buyers\Controllers\Site\Auth;

use App\Modules\Buyers\Models\Buyer;
use Auth;
use Validator;
use Illuminate\Http\Request;
use HZ\Illuminate\Mongez\Managers\ApiController;

class LoginController extends ApiController
{
    /**
     * Login the user
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = $this->scan($request);
        if ($validator->passes()) {
            $credentials = $request->only(['email', 'password']);
            if (!Auth::guard('buyer')->attempt($credentials)) {
                return $this->badRequest([
                    'errors' => [
                        'Invalid Data'
                    ]
                ]);
        } else {
                $buyer = user('buyer');

                $buyerInfo = $this->buyersRepository->wrap($buyer)->toArray($request);
                $buyerInfo['accessToken'] = $this->buyersRepository->generateAccessToken($buyer, $request);

                return $this->success([
                    'success' => true,
                    'record'  => $buyerInfo
                ]);
            }
        } else {
            return $this->badRequest([
                'errors' => $validator->errors()->all()
            ]);
        }
    }

    /**
     * Determine whether the passed values are valid
     *
     * @return mixed
     */
    private function scan(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    }
}
