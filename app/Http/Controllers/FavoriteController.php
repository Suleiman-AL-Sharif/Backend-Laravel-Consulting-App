<?php

namespace App\Http\Controllers;

use App\Models\Expertise;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Nette\Utils\ArrayList;

class FavoriteController extends Controller
{
   public function addFavorite($ex_id){

    $favorite= new Favorite();

    $favorite->user_id =  auth()->user()->id;
    $favorite->expertise_id = $ex_id ;

    $favorite->save();

    return response()->json([
        "status"=>201,
        "message"=>"expertise has been added to favorites ",

       ]);
   }

   public function showFavorite(){

    $favorite = Favorite::where('user_id', auth()->user()->id)->get();

    $res[] = new ArrayList();
    foreach($favorite as $ex) {
    $expertise = Expertise::where('id',$ex->expertise_id)->get();

    $res[$ex->id] = $expertise;
    }

    return response()->json([
    'res' => $res]) ;




}
}
