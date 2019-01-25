<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\APIController;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends APIController
{

    /**
     * Parametry
     *
     * Wymagane:
     * email, password
     *
     */

    public function login()
    {


        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->response
                ->setMessage(__('messages.login.wrong'))
                ->setFailureStatus(400)
                ->getResponse();
        }
        $user = $this->guard()->user();

        return $this->response
            ->setMessage(__('messages.login.success'))
            ->setData([
                'user' => $user,
            ])
            ->setSuccessStatus()
            ->getLoginResponse($token);
    }


    public function logout()
    {
        JWTAuth::parseToken()->invalidate();
        $this->guard()->logout();

        return $this->response
            ->setMessage(__('messages.logout'))
            ->setSuccessStatus()
            ->getLogoutResponse();
    }
}
