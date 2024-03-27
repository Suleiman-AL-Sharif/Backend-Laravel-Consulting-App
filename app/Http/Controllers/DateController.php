<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\User;
use App\Models\Expertise;
use Illuminate\Http\Request;
use Nette\Utils\ArrayList;

class DateController extends Controller
{

    public function create1 (Request $request){

        $request->validate([
            "day"=>"required",
           "time"=>"required",
          ]);



          $Date = new Date();
          $Date->user_id= auth()->user()->id;
          $Date->day =  $request->day;
          $Date->time = $request->time;
          $Date->expertises_id =  $request->expertises_id;

          $Date->save();
          return response()->json([
           "status"=>200,
           "message"=>"time created successfully ",

          ]);
     }

   public function reserve($date_id){
    $date = Date::findOrFail($date_id);
      $experties = Expertise::find($date->expertises_id);

    if($date->available == true){

        $user = User::find( auth()->user()->id);
        $expirt = User :: find( $experties->user_id);
        $cost = $experties['price'];
        $coins = $user['coins'];
        if($coins >= $cost ){
        // $date->user_id =$user->id;
        $date->update(['user_id' =>auth()->user()->id]) ;
            $expirt->update(['coins' =>$expirt->coins+$cost]) ;
            $user->update(['coins' =>$user->coins-$cost]) ;
            $expirt->save();
            $user->save();
            $date->available = false;
            $date->save();
            return response()->json(["message"=>"reserve done"]);
        }else{
            return response()->json(["message"=>"you dont have coins"]);
        }
    }else{
        return response()->json(["message"=>" this date was reserved"]);
    }

   }


   public function time( $id , $day){

   $time =  Date::where([
        'expertises_id'=> $id,
        'day'=>$day,
        'available'=>true
    ])->select('time')->get();


    return response()->json([
        "status"=>200,
        "time"=> $time,
    ]);
   }


   public function dates (){

    $expertise = Expertise::where('user_id', auth()->user()->id)->get();

    $res[] = new ArrayList();
    foreach($expertise as $ex) {
    $dates = Date::where([
        'expertises_id'=> $ex->id,
         'available'=>false
   ])->get();

    $res[$ex->id] = $dates;
    }

    return response()->json([
    'res' => $res]) ;

   }

}
