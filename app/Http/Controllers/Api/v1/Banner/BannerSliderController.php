<?php

namespace App\Http\Controllers\Api\v1\Banner;

use App\Http\Controllers\Controller;
use App\Models\BannerSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use \Illuminate\Http\JsonResponse;

class BannerSliderController extends Controller
{
    // Get the home page banner slider
    public function getHomeBannerSlider(): JsonResponse
    {
        $data = BannerSlider::where('name','=','home')->where('is_active',true)->get();
        return Response::json($data,ResponseAlias::HTTP_OK);
    }
}
