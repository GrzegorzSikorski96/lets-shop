<?php

namespace App\Helpers;

use App\Services\JWTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIResponse
{
    protected $service;
    protected $request;

    protected $message = "";
    protected $data = [];
    protected $response_code = null;
    protected $success = true;

    public function __construct(JWTService $service, Request $request)
    {
        $this->service = $service;
        $this->request = $request;
    }

    public function getResponse()
    {
        if (request()->headers->has('Authorization')) {
            if ($this->service->isValid($this->request)) {
                //return $this->respondWithToken($this->service->refreshToken());

                //Dla wygodniejszego testowania Postmanem wyłączam resetowanie tokenu
                return $this->respondWithToken($this->service->getToken());
            }
            return response()->json([
                'message' => __('messages.token.invalid'),
                'data' => $this->data,
                'success' => false,
                'auth' => false,
            ], 401);
        }
        return $this->respondWithoutToken();
    }

    public function getLoginResponse($token)
    {
        return $this->respondWithToken($token);
    }

    public function getLogoutResponse()
    {
        return $this->respondWithoutToken();
    }

    private function respondWithToken($token)
    {
        //$user = Auth::Guard('api')->user();

        return response()->json([
            'token' => $token,
            'message' => $this->message,
            'data' => $this->data,
            'success' => $this->success,
            'auth' => true,
            //'role' => $user->role->name
        ], $this->response_code);
    }

    private function respondWithoutToken()
    {
        return response()->json([
            'message' => $this->message,
            'data' => $this->data,
            'success' => $this->success,
            'auth' => false,
        ], $this->response_code);
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setSuccessStatus()
    {
        $this->response_code = 200;
        $this->success = true;
        return $this;
    }

    public function setFailureStatus($code)
    {
        $this->response_code = $code;
        $this->success = false;
        return $this;
    }
}