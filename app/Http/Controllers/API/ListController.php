<?php

namespace App\Http\Controllers\API;

use App\Models\ShopList;

class ListController extends APIController
{
    public function getGroupLists($id)
    {
        if ($group = $this->group_service->findGame($id)) {
            return $this->response
                ->setData(["lists" =>$group->shopLists])
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();
    }

    public function getList($id)
    {
        if ($list = ShopList::find($id)) {
            return $this->response
                ->setData(['list' => $list])
                ->setSuccessStatus()
                ->getResponse();
        }
        return $this->getListNotFoundResponse();
    }

    public function changeCompletedStatus($id){
        if ($list = ShopList::find($id)) {

            $list->completed = !$list->completed;
            $list->save();

            return $this->response
                ->setMessage(__('messages.list.status'))
                ->setData(['list' => $list])
                ->setSuccessStatus()
                ->getResponse();
        }
        return $this->getListNotFoundResponse();
    }

    public function getListNotFoundResponse()
    {
        return $this->response
            ->setMessage(__('messages.list.not.found'))
            ->setFailureStatus(400)
            ->getResponse();
    }

}