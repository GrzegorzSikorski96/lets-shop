<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\ShopList;
use Illuminate\Http\Request;

class ListController extends APIController
{
    public function getGroupLists($group_id)
    {
        if ($group = $this->group_service->findGroup($group_id)) {
            return $this->response
                ->setData(["lists" => $group->shopLists])
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();
    }

    public function getList($id)
    {
        if ($list = ShopList::find($id)) {
            return $this->response
                ->setData([
                    'list' => $list,
                    'products' => $list->products,
                    'shops' => $list->group->shops,
                    'categories' => Category::all(),
                    'exampleProducts' => CategoryProduct::all(),
                    ])
                ->setSuccessStatus()
                ->getResponse();
        }
        return $this->getListNotFoundResponse();
    }

    public function changeCompletedStatus($id)
    {
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

    /**
     * Parametry
     *
     * Wymagane:
     * name
     *
     */

    public function createList($group_id, Request $request)
    {
        if ($group = $this->group_service->findGroup($group_id)) {

            $list = ShopList::create([
                'name' => $request['name'],
                'group_id' => $group->id
            ]);

            return $this->response
                ->setData(["list" => $list])
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();
    }

    public function removeList($list_id){
        if ($list = ShopList::find($list_id)) {

            foreach($list->products as $product){
                $product->delete();
            }
            $list->delete();

            return $this->response
                ->setMessage(__('messages.list.removed'))
                ->setData(['list' => $list])
                ->setSuccessStatus()
                ->getResponse();
        }
        return $this->getListNotFoundResponse();
    }

    private function getListNotFoundResponse()
    {
        return $this->response
            ->setMessage(__('messages.list.not.found'))
            ->setFailureStatus(400)
            ->getResponse();
    }

}