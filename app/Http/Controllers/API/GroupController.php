<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends APIController
{
    public function getGroup($group_id)
    {
        if ($group = $this->group_service->findGroup($group_id)) {
            return $this->response
                ->setData(['group' => $group])
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();
    }

    public function getGroups()
    {
        $groups = $this->auth->groups;

        return $this->response
            ->setData(['groups' => $groups])
            ->setSuccessStatus()
            ->getResponse();
    }

    public function removeGroup($group_id)
    {
        if ($group = $this->group_service->findGroup($group_id)) {
            $group->deleteGroup();
            return $this->response
                ->setMessage(__('messages.group.removed'))
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();
    }

    public function createGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'min:3|required',
        ]);

        if ($validator->fails()) {
            return $this->response
                ->setMessage(__('messages.validation.fail'))
                ->setData($validator->errors())
                ->setFailureStatus(400)
                ->getResponse();
        }

        $group = Group::create([
            'name' => $request['name'],
            'owner_id' => $this->auth->id
        ]);

        GroupUser::create([
            'group_id' => $group->id,
            'user_id' => $this->auth->id
        ]);

        return $this->response
            ->setMessage(__('messages.group.created'))
            ->setData(['group' => $group])
            ->setSuccessStatus()
            ->getResponse();
    }

    public function invite($group_id, Request $request)
    {
        if ($group = $this->group_service->findGroup($group_id)) {
            if (!$group->isOwner()) {
                return $this->response
                    ->setMessage(__('messages.access.denied'))
                    ->setData(['group' => $group])
                    ->setFailureStatus(401)
                    ->getResponse();
            }

            if (($user = User::where('email', $request['email']))) {
                if (!$group->findUser($user->id)) {
                    GroupUser::create([
                        'group_id' => $group->id,
                        'user_id' => $user->id
                    ]);

                    return $this->response
                        ->setMessage(__('messages.invite.success'))
                        ->setData(['group' => $group])
                        ->setSuccessStatus()
                        ->getResponse();
                }
            }
            return $this->response
                ->setMessage(__('messages.invite.fail'))
                ->setFailureStatus(400)
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();
    }

    public function kick($group_id, Request $request)
    {
        if ($group = $this->group_service->findGroup($group_id)) {
            if (!$group->isOwner()) {
                return $this->response
                    ->setMessage(__('messages.access.denied'))
                    ->setData(['group' => $group])
                    ->setFailureStatus(401)
                    ->getResponse();
            }

            if (!$group->findUser($request['user_id'])) {
                $group->users->where('user_id', $request['user_id'])->first()->delete();

                return $this->response
                    ->setMessage(__('messages.kick.success'))
                    ->setData(['group' => $group])
                    ->setSuccessStatus()
                    ->getResponse();
            }
            return $this->response
                ->setMessage(__('messages.kick.fail'))
                ->setFailureStatus(400)
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();
    }

}