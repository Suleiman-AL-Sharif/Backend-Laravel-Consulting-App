<?php

namespace App\Http\Controllers;

use App\Models\Expertise;
use App\Models\Date;
use Illuminate\Http\Request;

class ExpertiseController extends Controller
{

    public function create (Request $request){

        $request->validate([
            "name"=>"required",
           "details"=>"required",
           "type_id"=>"required",
           "price"=>"required",
           "adress"=>"required",
           "phone_n"=>"required",
          ]);

          if ($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->extension();
            $path = $image->move('images',$name);
            $path = (string) $path;
          } else{
            $path = null;
          }

          $expertise = new Expertise();

          $expertise->image_url =$path;
          $expertise->user_id = auth()->user()->id;
          $expertise->type_id =  $request->type_id;
          $expertise->name = $request->name;
          $expertise->details =  $request->details;
          $expertise->price = $request->price;
          $expertise->phone_n = $request->phone_n;
          $expertise->adress = $request->adress;

          $expertise->save();

          return response()->json([
           "status"=>201,
           "message"=>"expertise created successfully ",

          ]);

     }

     public function list ($id){

        $expertise = Expertise::where('type_id',$id)->get();

        return response()->json([
            "status"=>201,
            "message"=>"expertise ",
            "data"=> $expertise
        ]);
     }

     public function details($ex_id){

        $expertise = Expertise::where('id',$ex_id)->find( $ex_id);
        $dates = Date::where('expertises_id',$ex_id)->get();

        return response()->json([
            "status"=>true,
            "message"=>"details ",
            "data"=> $expertise,
            "dates"=>$dates
        ]);
     }

     public function delete($ex_id){

        $user_id = auth()->user()->id;

        if(Expertise::where([
            "user_id" => $user_id,
            "id" => $ex_id
        ])->exists()){
            $expertise = Expertise::find( $ex_id);
            $expertise->delete();
            return response()->json([
                "status"=>true,
                "message"=>" expertise has been deleted",
            ]);
        }else{
            return response()->json([
                "status"=>false,
                "message"=>"not exists",
            ]);
        }
     }

     public function search($name){

        $search= Expertise::where('name',$name)->get();

        return response()->json([
            "status"=>true,
            "result"=> $search,
        ]);
     }
}
