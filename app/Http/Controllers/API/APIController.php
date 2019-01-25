<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIResponse;
use App\Services\JWTService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;



class APIController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $jwtservice;
    protected $response;
    protected $auth;

    public function __construct(JWTService $service, APIResponse $response)
    {
        $this->response = $response;
        $this->jwtservice = $service;
        $this->auth = $this->guard()->user();
    }

    public function guard() {
        return Auth::Guard('api');
    }
}