<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
     public function add()
    { 
      try {      
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }  
                $validator = Validator::make(request()->all(), [
                'name' => 'required|string', 
                'rate' => 'required|integer', 
                'user_id' => 'required|string' 
            ]);

      
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
           
              
             $skill = Skill::create(array_merge(
                    $validator->validated() 
                ));
       
            return response()->json(['message' => 'Skill successfully created 👍','skill'=>$skill],200); 
         
        } catch (\Throwable $th) {
            // throw $th;
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
          $skill=Skill::where("id",$id)
          ->where("user_id",auth()->user()["id"])
          ->delete();
          if(!$skill)  return response()->json(['message' => 'Sorry this skill does not belong to you or does not exist⚠️','skill'=>$skill],401); 

          return response()->json(['message' => 'Skill successfully Deleted 👍','skill'=>$skill],200); 

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
        $skill=Skill::where("user_id",$user_id)->get();
        return response()->json(['message' => 'Skill successfully Loaded 👍','skill'=>$skill],200); 
      } catch (\Throwable $th) {
        //   throw $th;
          return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
        
      }
 }
}