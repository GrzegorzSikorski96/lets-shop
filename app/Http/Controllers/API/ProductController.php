<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\AddProduct;
use App\Models\Product;

class ProductController extends APIController
{
    public function createOrUpdate(AddProduct $request)
    {
        $data = $request->all();
        if (isset($request['product_id'])) {
            if ($product = Product::find($request['product_id'])) {

                $product->fill($data)->save();
                return $this->response
                    ->setMessage(__('messages.product.updated'))
                    ->setData(['list' => $product->shopList])
                    ->setSuccessStatus()
                    ->getResponse();
            }
            return $this->getProductNotFoundResponse();
        }

        $product = Product::create($data);

        return $this->response
            ->setMessage(__('messages.product.added'))
            ->setData(['list' => $product->shopList])
            ->setSuccessStatus()
            ->getResponse();

    }

    public function removeProduct($product_id)
    {
        if ($product = Product::find($product_id)) {

            $product->delete();
            return $this->response
                ->setMessage(__('messages.product.removed'))
                ->setData(['list' => $product->shopList])
                ->setSuccessStatus()
                ->getResponse();
        }
        return $this->getProductNotFoundResponse();
    }



//
//    public function addShop($group_id, Request $request)
//    {
//        if ($group = $this->group_service->findGroup($group_id)) {
//            return $this->response
//                ->setData(['group' => $group])
//                ->setSuccessStatus()
//                ->getResponse();
//        }
//
//        return $this->group_service->getGroupNotFoundResponse();
//    }


    private function getProductNotFoundResponse()
    {
        return $this->response
            ->setMessage(__('messages.product.not.found'))
            ->setFailureStatus(400)
            ->getResponse();
    }

}