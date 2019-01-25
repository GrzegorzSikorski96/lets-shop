<?php

namespace App\Http\Controllers\API;


use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends APIController
{
    public function addProduct(Request $request)
    {





    }


    public function addShop($group_id, Request $request)
    {
        if ($group = $this->group_service->findGroup($group_id)) {
            return $this->response
                ->setData(['group' => $group])
                ->setSuccessStatus()
                ->getResponse();
        }

        return $this->group_service->getGroupNotFoundResponse();
    }


    private function getProductNotFoundResponse()
    {
        return $this->response
            ->setMessage(__('messages.product.not.found'))
            ->setFailureStatus(400)
            ->getResponse();
    }

}