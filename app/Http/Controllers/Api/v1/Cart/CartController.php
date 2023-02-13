<?php

namespace App\Http\Controllers\Api\v1\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Expr\Cast\Double;
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

        $cartTotal = DB::table('carts')
            ->where('user_id',$id)
            ->sum('carts.line_amount');

        $badgeCount = DB::table('carts')
            ->where('user_id',$id)
            ->count('id');


        return Response::json([
            'data' => $data,
            'cartTotal' => (double)$cartTotal,
            'badgeCount' => $badgeCount,
        ], ResponseAlias::HTTP_OK);
    }

    function  addToCart(Request $request): JsonResponse
    {
        $cart = DB::table('carts')
            ->where('product_id',$request->get('product_id'))
            ->first();

        if(empty($cart)) {
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

            $cartTotal = DB::table('carts')
                ->where('user_id',$data->user_id)
                ->sum('carts.line_amount');

            $badgeCount = DB::table('carts')
                ->where('user_id',$data->user_id)
                ->count('id');

            return Response::json([
                'data' => $data,
                'cartTotal' => (double)$cartTotal,
                'badgeCount' => $badgeCount,
            ], ResponseAlias::HTTP_CREATED);
        }
        else {
            // update cart
            $lineAmount = 0.0;
            $discount = (double) $request->get('discount');
            if ($discount > 0.0) {
                $lineAmount =  $request->get('discounted_price') * ($request->get('qty') + $cart->qty);
            }
            else  {
                $lineAmount = $request->get('price') * ($request->get('qty') + $cart->qty);
            }
            DB::table('carts')
                ->where('id',$cart->id)
                ->update(
                    [
                        'qty' => $request->get('qty') + $cart->qty,
                        'price' => $request->get('price'),
                        'discounted_price' => $request->get('discounted_price'),
                        'discount' => $request->get('discount'),
                        'line_amount' => $lineAmount
                    ]
                );

            // select cart
            $data = DB::table('carts')
                ->where('carts.id',$cart->id)
                ->join('products','carts.product_id','=','products.id')
                ->join('prices','products.id','=','prices.product_id')
                ->select(
                    'carts.*',
                    'products.thumbnail',
                    'prices.currency',
                )
                ->first();

            // sum line amount total
            $cartTotal = DB::table('carts')
                ->where('user_id',$data->user_id)
                ->sum('carts.line_amount');

            $badgeCount = DB::table('carts')
                ->where('user_id',$data->user_id)
                ->count('id');


            return Response::json([
                'data' => $data,
                'cartTotal' => (double)$cartTotal,
                'badgeCount' => $badgeCount,
            ], ResponseAlias::HTTP_OK);

        }

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

        $cartTotal = DB::table('carts')
            ->where('user_id',$data->user_id)
            ->sum('carts.line_amount');

        $badgeCount = DB::table('carts')
            ->where('user_id',$data->user_id)
            ->count('id');

        return Response::json([
            'data' => $data,
            'cartTotal' => (double)$cartTotal,
            'badgeCount' => $badgeCount,
        ], ResponseAlias::HTTP_OK);

    }

    function  delete(Request $request): JsonResponse
    {
        $result = false;

        $cart = DB::table('carts')
            ->where('id',$request->get('id'))
            ->first();


        $data = DB::table('carts')
            ->where('id',$request->get('id'))
            ->delete();

        if ($data != 0) {
            $result = true;
        }

        $cartTotal = DB::table('carts')
            ->where('user_id',$cart->user_id)
            ->sum('carts.line_amount');

        $badgeCount = DB::table('carts')
            ->where('user_id',$cart->user_id)
            ->count('id');

        return Response::json([
            'deleted' => $result,
            'cartTotal' => (double)$cartTotal,
            'badgeCount' => $badgeCount,
        ], ResponseAlias::HTTP_OK);
    }

    function checkout(Request $request): JsonResponse
    {

        $result = false;

        $data = DB::table('carts')
            ->where('user_id',$request->get('user_id'))
            ->delete();

        if ($data != 0) {
            $result = true;
        }

        return Response::json([
            'checkout' => $result,

        ], ResponseAlias::HTTP_OK);


    }
}
