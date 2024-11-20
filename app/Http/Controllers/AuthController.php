<?php

namespace App\Http\Controllers;

use App\Http\Services\CreateUserService;
use App\Http\Services\LogginService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signup(Request $request): JsonResponse
    {
        try{
            $createUser = app()->makeWith(CreateUserService::class,[
                'request' => $request
            ]);

            $create = $createUser->toCreate();

            if(!$create['status']){
                throw new \Exception($create['response'], 400);
            }

            return response()->json([
                "status"  => true,
                "message" => $create['response'],
            ],201);
        }catch(\Exception $e){
            return response()->json([
                "status"  => false,
                "message" => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function signin(Request $request): JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $loginUser = app()->makeWith( LogginService::class,[
                'credentials' => $validatedData
            ]);

            $login = $loginUser->toLogin();

            if(!$login['status']){
                throw new \Exception($login['response'], 401);
            }

            return response()->json([
                "status"  => true,
                "message" => $login['response'],
            ],200);
        }catch(\Exception $e){
            return response()->json([
                "status"  => false,
                "message" => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
