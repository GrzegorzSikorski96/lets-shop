<?php

namespace App\Services;


use App\Models\Group;

class GroupService
{
    public function findGame($id){
        if ($group = Group::find($id)) {
            return $group;
        }
        return false;
    }

    public function getGroupNotFoundResponse()
    {
       return function (\App\Helpers\APIResponse $response)
        {
            return $response
                ->setMessage(__('messages.not.found'))
                ->setFailureStatus(404)
                ->getLogoutResponse();
        };
    }

}