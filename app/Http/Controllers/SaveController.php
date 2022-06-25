<?php

namespace App\Http\Controllers;

use App\Models\Save;
use App\Http\Requests\StoreSaveRequest;
use App\Http\Requests\UpdateSaveRequest;
use Illuminate\Support\Facades\Validator;

class SaveController extends Controller
{
     
    public function add()
    {
        try {      
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }  
               request()->validate([
                'saved_user_id' => 'required|integer', 
            ]);
            $user_id=auth()->user()["id"]; 
            if( $user_id==request()->saved_user_id){
             return response()->json(['message' => 'sorry you cannot save your self ⚠️'], 401); 
            }
            $dataExist=Save::where("user_id",$user_id)
            ->where('saved_user_id',request()->saved_user_id)
            ->first();

        if(!$dataExist){
           $user= Save::create(array_merge(
                     request()->all(),
                    [
                        "user_id"=>$user_id
                    ]
           ));
        return response()->json(['message' => 'Successfully Saved user 👍','saved_user'=>$user],200); 
        } 
       $dataExist->delete();
        return response()->json(['message' => 'Successfully Remove Saved User 👍'],200); 
        
    
    }
  catch (\Throwable $th) {
        //   throw $th;
          return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
        
      }
    }

 public function get($user_id)
 {
      try {
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }  
        $data=Save::where("user_id",$user_id)->with("user")->get();
        return response()->json(['message' => 'Successfully Loaded  Saved freelancer👍','saved'=>$data],200); 
      } catch (\Throwable $th) {
        //   throw $th;
          return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
        
      }
 }
}