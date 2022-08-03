<?php

namespace App\Http\Controllers\Api\v1\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BrandController extends Controller
{
    //Get the list of brands
    public function getBrands(): JsonResponse
    {
        $data = Brand::all();
        return Response::json($data,ResponseAlias::HTTP_OK);
    }
}
