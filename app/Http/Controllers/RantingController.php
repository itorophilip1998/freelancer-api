<?php

namespace App\Http\Controllers;

use App\Models\Ranting;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreRantingRequest;
use App\Http\Requests\UpdateRantingRequest;

class RantingController extends Controller
{
       public function add()
    { 
      try {      
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }  
                $validator = Validator::make(request()->all(), [
                'rate' => 'required|integer|min:1|max:5', 
                'user_id' => 'required|integer', 
                'rater_id' => 'required|integer' 
            ]);

      
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }              
           
            $rater_exist=Ranting::where("user_id",request()->user_id)->first();
            if($rater_exist){
                $rater_exist->update(["rate"=>request()->rate]);
               return response()->json(['message' => 'Rating successfully updated 👍','ranting'=>$rater_exist],200); 

            }
            
             $ranting = Ranting::create(array_merge(
                    $validator->validated() 
                ));
       
            return response()->json(['message' => 'Rating successfully created 👍','ranting'=>$ranting],200); 
         
        } catch (\Throwable $th) {
            throw $th;
                   return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
        
        }
        
    }
 public function remove($id)
 {
      try {
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            } 
          $ranting=Ranting::where("id",$id)
          ->where("user_id",auth()->user()["id"])
          ->delete();
          if(!$ranting)  return response()->json(['message' => 'Sorry this Ranting does not belong to you or does not exist⚠️','ranting'=>$ranting],401); 
          return response()->json(['message' => 'Rating successfully Deleted 👍','ranting'=>$ranting],200); 

      } catch (\Throwable $th) {
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
        $ranting=Ranting::where("user_id",$user_id)->get();
        $rate=round($ranting->sum("rate") / 5);
       
        return response()->json(['message' => 'Rating successfully Loaded 👍','rate_star'=>$rate,'rantings'=>$ranting],200); 
      } catch (\Throwable $th) {
        //   throw $th;
          return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
        
      }
 }
}