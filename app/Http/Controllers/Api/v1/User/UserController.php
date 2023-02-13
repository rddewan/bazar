<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    function getUser($id): JsonResponse
    {
        $data = DB::table('users')
            ->where('id',$id)
            ->select('id','name','email','phone')
            ->first();

        return Response::json($data, ResponseAlias::HTTP_OK);

    }


    function delete(Request $request): JsonResponse
    {

        $result = false;
        // delete user
        $delete = DB::table('users')
            ->where('id',$request->get('user_id'))
            ->delete();

        if ($delete != 0) {
            // clear cart
            $data = DB::table('carts')
                ->where('user_id',$request->get('user_id'))
                ->delete();

            $result = true;
        }

        return Response::json([
            'delete' => $result,

        ], ResponseAlias::HTTP_OK);


    }
}
