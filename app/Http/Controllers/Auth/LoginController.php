<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $input = $request->get('data',[]);
        if (empty($input['email'])){
            return response()->json('email is required',400);
        }
        if (empty($input['password'])){
            return response()->json('password is required',400);
        }

        $userInfo = User::where('email',$input['email'])->first();
        if (empty($userInfo)){
            return response()->json('user doesn\'t exists',400);
        }

        if ($input['password'] !== $userInfo['password']){
            return response()->json('password wrong',400);
        }

        Auth::loginUsingId($userInfo['id']);
        return response()->json(['status'=>'success','userInfo'=>$userInfo]);
    }

    public function register(Request $request): JsonResponse
    {
        // $input = $request->get('data',[]);
        // if (empty($input['email'])){
        //     return response()->json('email is required',400);
        // }
        // if (empty($input['password'])){
        //     return response()->json('password is required',400);
        // }

        // if (empty($input['confirm_password'])){
        //     return response()->json('confirm password is required',400);
        // }

        // if ($input['password'] != $input['confirm_password']){
        //     return response()->json('password does not match',400);
        // }

        // unset($input['confirm_password']);

        // $userInfo = User::where('email',$input['email'])->first();
        // if (!empty($userInfo)){
        //     return response()->json('Email already exists',400);
        // }

        // User::insert($input);
        // return response()->json('success');
    }
}
