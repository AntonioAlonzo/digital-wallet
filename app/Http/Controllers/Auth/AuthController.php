<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the authentication of existing users.
    |
    */

    public function authenticate(Authenticate $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return responder()->error('invalid_credentials');
            }
        } catch (JWTException $e) {
            return responder()->error('could_not_create_token');
        }

        return response()->json(compact('token'));
    }
}