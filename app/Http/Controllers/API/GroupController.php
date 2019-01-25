<?php

namespace App\Http\Controllers\API;


use App\Models\Group;

class GroupController extends APIController
{
    public function getGroup($id)
    {
        if ($group = Group::find($id)) {
            return $this->response
                ->setData(['group' => $group])
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->response
            ->setMessage(__('messages.group.not.found'))
            ->setSuccessStatus()
            ->getResponse();
    }

    public function getGroups()
    {
        $groups = $this->auth->groups;

        return $this->response
            ->setData(['groups' => $groups])
            ->setSuccessStatus()
            ->getResponse();
    }

    public function remove($id)
    {
        if ($group = Group::find($id)) {
            $group->delete();
            return $this->response
                ->setData(['group' => $group])
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->response
            ->setMessage(__('messages.group.not.found'))
            ->setSuccessStatus()
            ->getResponse();
    }


}
