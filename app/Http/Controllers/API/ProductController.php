<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\AddProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends APIController
{

    /**
     * Parametry
     *
     * Wymagane:
     * shop_list_id, name
     *
     * Opcjonalne:
     * product_id, category_id, shop_id, description
     *
     */

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


    /**
     * Parametry
     *
     * Wymagane:
     * product_id
     *
     */

    public function changeStatus(Request $request){
        if ($product = Product::find($request['product_id'])) {

            $product->status = !$product->status;

            return $this->response
                ->setMessage(__('messages.product.status'))
                ->setData(['list' => $product->shopList])
                ->setSuccessStatus()
                ->getResponse();
        }
        return $this->getProductNotFoundResponse();
    }

    private function getProductNotFoundResponse()
    {
        return $this->response
            ->setMessage(__('messages.product.not.found'))
            ->setFailureStatus(400)
            ->getResponse();
    }

}