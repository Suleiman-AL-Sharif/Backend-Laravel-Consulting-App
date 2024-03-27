<?php

namespace App\Http\Controllers;

use App\Models\Expertise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   public function register(Request $request){

    $request->validate([
     "name"=>"required",
     "email"=>"required|email|unique:users",
     "password"=>"required|confirmed",
     "phone_n"=>"required"
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password =bcrypt($request->password);
    $user->phone_n = $request->phone_n;
    $user->is_expirt = $request->is_expirt;

    $user->save();
    return response()->json([
    "message"=>"user created"
    ],201);
   }

   public function login(Request $request){

   $login_data = $request->validate([

        "email"=>"required",
        "password"=>"required",
       ]);

       if(!auth()->attempt( $login_data)){

        return response()->json([
         "status"=>false,
         "message"=>"invalid "
        ]);
       }

       $token =auth()->user()->createToken("auth_token")->accessToken;

       return response()->json([
        "status"=>true,
        "message"=>"logged in successfully ",
        "access token"=> $token
       ]);
   }

   public function logout(Request $request){


      $token = $request->user()->token();

      $token->revoke();

      return response()->json([
         "status"=>true,
         "message"=>"logged out successfully ",

        ]);
   }

   public function coins(){

    $coins=User::where('id', auth()->user()->id)->select('coins','name')->get();

    return response()->json([
        "status"=>200,
        "coins"=> $coins
       ]);
   }

}
