<?php

namespace App\Services;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTService
{
    public function refreshToken(){
        $token = JWTAuth::parseToken()->refresh();
        return $token;
    }

    public function isValid($request){
        try{
            JWTAuth::setRequest($request);
            $user = JWTAuth::parseToken()->authenticate();

            if(!$user){
                return false;
            }

            return true;
        } catch(TokenExpiredException $e){
            return false;
        } catch(TokenInvalidException $e){
            return false;
        } catch(JWTException $e){
            return false;
        }
    }

    public function getToken(){
        $token = JWTAuth::getToken()->get();
        return $token;
    }
}
