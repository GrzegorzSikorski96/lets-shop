<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIResponse;
use App\Services\GroupService;
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
    protected $group_service;

    /**
     * @SWG\Swagger(
     *   basePath="/app",
     *   @SWG\Info(
     *     title="Lets-shop API",
     *     version="1.0.0"
     *   )
     * )
     */
    public function __construct(JWTService $service, APIResponse $response, GroupService $group_service)
    {
        $this->response = $response;
        $this->jwtservice = $service;
        $this->auth = $this->guard()->user();
        $this->group_service = $group_service;
    }

    public function guard() {
        return Auth::Guard('api');
    }
}