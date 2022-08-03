<?php

namespace App\Http\Controllers\Api\v1\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class CategoryController extends Controller
{
    //Get the list of product categories
    public function getCategories(): JsonResponse
    {
        $data = Category::all();
        return Response::json($data, ResponseAlias::HTTP_OK);
    }
}
