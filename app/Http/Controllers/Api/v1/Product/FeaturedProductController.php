<?php

namespace App\Http\Controllers\Api\v1\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FeaturedProductController extends Controller
{
    function  getFeaturedProducts(): JsonResponse
    {

        $result = DB::table('products')
            ->join('featured_products','products.id','=','featured_products.product_id')
            ->join('prices','products.id','=','prices.product_id')
            ->join('inventories','products.id','=','inventories.product_id')
            ->join('categories','products.category_id','=','categories.id')
            ->join('brands','products.brand_id','=','brands.id')
            ->orderBy('products.id')
            ->select(
                'products.*',
                'prices.price','prices.discount','prices.currency',
                'inventories.qty',
                'brands.name AS brand',
                'categories.name AS category',
            )
            ->get();

        return Response::json($result, ResponseAlias::HTTP_OK);
    }
}
