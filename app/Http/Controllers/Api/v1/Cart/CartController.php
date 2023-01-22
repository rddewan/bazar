<?php

namespace App\Http\Controllers\Api\v1\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CartController extends Controller
{

    function getUserCart($id): JsonResponse {
        $data = DB::table('carts')
            ->where('user_id',$id)
            ->join('prices','carts.product_id','=','prices.product_id')
            ->join('products','carts.product_id','=','products.id')
            ->select(
                'carts.*',
                'products.thumbnail',
                'prices.currency',
            )
            ->get();


        return Response::json($data, ResponseAlias::HTTP_OK);
    }

    function  addToCart(Request $request): JsonResponse
    {
        $id = DB::table('carts')->insertGetId([
            'user_id' => $request->get('user_id'),
            'product_id' => $request->get('product_id'),
            'product_name' => $request->get('product_name'),
            'short_description' => $request->get('short_description'),
            'qty' => $request->get('qty'),
            'price' => $request->get('price'),
            'discounted_price' => $request->get('discounted_price'),
            'discount' => $request->get('discount'),
            'line_amount' => $request->get('line_amount'),
        ]);

        $data = DB::table('carts')
            ->where('carts.id',$id)
            ->join('products','carts.product_id','=','products.id')
            ->join('prices','products.id','=','prices.product_id')
            ->select(
                'carts.*',
                'products.thumbnail',
                'prices.currency',
            )
            ->first();

        return Response::json($data, ResponseAlias::HTTP_CREATED);
    }

    function  update(Request $request): JsonResponse
    {
        DB::table('carts')
            ->where('id',$request->get('id'))
            ->update(
                [
                    'qty' => $request->get('qty'),
                    'price' => $request->get('price'),
                    'discounted_price' => $request->get('discounted_price'),
                    'discount' => $request->get('discount'),
                    'line_amount' => $request->get('line_amount'),
                ]
            );

        $data = DB::table('carts')
            ->where('carts.id',$request->get('id'))
            ->join('products','carts.product_id','=','products.id')
            ->join('prices','products.id','=','prices.product_id')
            ->select(
                'carts.*',
                'products.thumbnail',
                'prices.currency',
            )
            ->first();

        return Response::json($data, ResponseAlias::HTTP_OK);
    }

    function  delete(Request $request): JsonResponse
    {
        $result = false;

        $data = DB::table('carts')
            ->where('id',$request->get('id'))
            ->delete();

        if ($data != 0) {
            $result = true;
        }

        return Response::json(['deleted' => $result], ResponseAlias::HTTP_OK);
    }
}
