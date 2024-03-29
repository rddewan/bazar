<?php

namespace App\Http\Controllers\Api\v1\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    //Get the list of paginated product
    function getProducts(Request $request): JsonResponse
    {

        $perPage = $request->get('perPage');
        $pageNumber = $request->get('pageNumber');
        $query = $request->get('search');

        if ($perPage == null || $pageNumber == null)  {
            return Response::json(
                ["message"=>"Request param is missing"],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        // search using laravel scout
        $results = Product::search($query)
            ->query(function ($query) {
                $query->join('prices','products.id','=','prices.product_id')
                    ->join('inventories','products.id','=','inventories.product_id')
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('brands','products.brand_id','=','brands.id')
                    ->orderBy('products.name','DESC')
                    ->select(
                        'products.*',
                        'prices.price','prices.discount','prices.currency',
                        'inventories.qty',
                        'brands.name AS brand',
                        'categories.name AS category',
                    );
            })
            ->paginate($perPage,'product',$pageNumber);

        return Response::json($results, ResponseAlias::HTTP_OK);

    }

    // search product
    public function searchProduct(Request $request): JsonResponse
    {
        $query = $request->get('query');

        if ($query) {
            $data = Product::query()
                ->where('sku','LIKE','%'.$query.'%')
                ->orWhere('name','LIKE','%'.$query.'%')
                ->orderBy('id','DESC')
                ->paginate(10);

            return Response::json($data,ResponseAlias::HTTP_OK);
        }

        return Response::json(['message'=> 'query param missing'],ResponseAlias::HTTP_BAD_REQUEST);

    }

    //Get the list of paginated thrashed product
    function getTrashedProducts(Request $request): JsonResponse
    {

        $perPage = $request->get('perPage');
        $pageNumber = $request->get('pageNumber');

        if ($perPage == null || $pageNumber == null)  {
            return Response::json(
                ["message"=>"Request param is missing"],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $result = Product::onlyTrashed()->paginate($perPage,['*'],'product',$pageNumber);

        return Response::json($result, ResponseAlias::HTTP_OK);
    }

    //Get the product by id
    function getProduct($id): JsonResponse
    {

        $product = DB::table('products')
            ->where('products.id','=',$id)
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
            ->first();

        $images = DB::table('product_images')
            ->select('image')
            ->where('product_id','=',$id)
            ->get();

        return Response::json([
            'product' => $product,
            'images' => $images
        ], ResponseAlias::HTTP_OK);
    }

    //Update product
    function updateProduct(Request $request): JsonResponse
    {
        $product = DB::table('products')->where('id','=',$request->get('id'))
            ->update([
                'name' => $request->get('name'),
                'short_description' => $request->get('short_description'),
                'long_description' => $request->get('long_description'),
                'brand' => $request->get('brand'),
                'is_active' => $request->get('is_active')
            ]);

        $result = DB::table('products')->where('id','=',$request->get('id'))->first();

        return Response::json($result, ResponseAlias::HTTP_OK);
    }

    //Soft delete product
    function softDeleteProduct($id): JsonResponse
    {

        $result = Product::find($id)->delete();

        return Response::json($result, ResponseAlias::HTTP_OK);
    }

    //Restore deleted product
    function restoreProduct(Request $request): JsonResponse
    {

        $result = Product::withTrashed()->findOrFail($request->get('id'))->restore();

        return Response::json($result, ResponseAlias::HTTP_OK);
    }

    //force delete product
    function destroy($id): JsonResponse
    {

        $result = Product::withTrashed()->findOrFail($id)->forceDelete();

        return Response::json($result, ResponseAlias::HTTP_OK);
    }


}
