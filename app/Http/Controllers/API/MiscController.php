<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\AddCategory;
use App\Http\Requests\AddShop;
use App\Models\Category;
use App\Models\Shop;

class MiscController extends APIController
{

    /**
     * Parametry
     *
     * Wymagane:
     * name, unit_type
     *
     */

    public function addCategory(AddCategory $request)
    {
        $category = Category::create($request);

        return $this->response
            ->setMessage(__('messages.category.created'))
            ->setData($category)
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * Parametry
     *
     * Wymagane:
     * name
     *
     */

    public function addShop($group_id, AddShop $request)
    {

        if ($group = $this->group_service->findGroup($group_id)) {

            $shop = Shop::create([
                'group_id' => $group->id,
                'name' => $request['name']
            ]);

            return $this->response
                ->setMessage(__('messages.shop.created'))
                ->setData($shop)
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();

    }


}