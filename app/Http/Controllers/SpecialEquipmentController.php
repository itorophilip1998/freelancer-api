<?php

namespace App\Http\Controllers;

use App\Models\SpecialEquipment;
use Illuminate\Support\Facades\Validator; 

class SpecialEquipmentController extends Controller
{
     public function add()
    { 
      try {      
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }  
                $validator = Validator::make(request()->all(), [
                'name' => 'required|string', 
                'skill_id' => 'required|integer', 
                'user_id' => 'required|string' 
            ]);

      
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
           
              
             $specialEquipment = SpecialEquipment::create(array_merge(
                    $validator->validated() 
                ));
       
            return response()->json(['message' => 'Special Equipment successfully created 👍','specialEquipment'=>$specialEquipment],200); 
         
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
          $specialEquipment=SpecialEquipment::where("id",$id)
          ->where("user_id",auth()->user()["id"])
          ->delete();
          if(!$specialEquipment)  return response()->json(['message' => 'Sorry this specialEquipment does not belong to you or does not exist⚠️','specialEquipment'=>$specialEquipment],401); 

          return response()->json(['message' => 'Special Equipment successfully Deleted 👍','specialEquipment'=>$specialEquipment],200); 

      } catch (\Throwable $th) {
        //   throw $th;
          return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
        
      }
 }
 public function get($skill_id)
 {
      try {
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }  
        $specialEquipment=SpecialEquipment::where("skill_id",$skill_id)->get();
        return response()->json(['message' => 'Special Equipment successfully Loaded 👍','specialEquipment'=>$specialEquipment],200); 
      } catch (\Throwable $th) {
        //   throw $th;
          return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
        
      }
 }
}