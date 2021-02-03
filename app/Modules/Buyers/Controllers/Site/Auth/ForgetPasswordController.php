<?php
namespace App\Modules\Buyers\Controllers\Site\Auth;

use Mail;
use Validator;
use Illuminate\Http\Request;
use HZ\Illuminate\Mongez\Managers\ApiController;

class ForgetPasswordController extends ApiController
{
    /**
     * Send an email to reset password
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = $this->isValid($request);
        if ($validator->passes()) {
            $cast = repo('buyers')->getBy('email', $request->email)->resource;
            $cast->code = mt_rand(10000, 99999);
            $cast->save();

            Mail::send([], [], function ($message) use ($cast) {
            $message->to($cast->email)
                ->subject('Reset password')
                // here comes what you want
                ->setBody("Your reset password code is: <strong>{$cast->code}</strong>", 'text/html'); // assuming text/plain
            });
            return $this->success();
        } else {
            return $this->badRequest([
                'errors' => [
                    'This email does not exist'
                ]
            ]);
        }
    }

    /**
     * Determine whether the passed values are valid
     *
     * @return mixed
     */
    private function isValid(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|exists:buyers,email',
        ]);
    }
}
