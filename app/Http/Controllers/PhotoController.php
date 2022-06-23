<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    public function add(Request  $request)
    { 
      try {      
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }  
                $validator = Validator::make(request()->all(), [
                'photo' => 'required|string',  
                'user_id' => 'required|string',
                'is_base64' => 'nullable|bool',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            
            
            if(request()->is_base64){ 
     
              $base64_str = substr($request->base64_image, strpos($request->base64_image, ",")+1);
              $image = base64_decode($base64_str); 
              Storage::disk('local')->put(auth()->user()["firstname"], $image);
              //decode base64 string
              $image = base64_decode($base64_str);
              
            }

            // create profile picture if there is no picture for frontend
            if(!request()->is_base64 && request()->hasFile('photo')){
                    $filename = request()->photo->getClientOriginalName();
                    $photo=request()->user_id.$filename;
                    $userExist=Photo::where( "user_id",request()->user_id)->first();    
                      $img =request()->photo->storeAs('photo',$photo,'public'); //upload  
                      $image=URL::to("storage")."/".$img;
                      
                    if(!$userExist){
                    $Photo = Photo::create([
                                'photo'=>$image,
                            "user_id"=>request()->user_id
                            ] );
                  return response()->json(['message' => 'Photo successfully created 👍','Photo'=>$Photo],200); 
         } 
         
           $image_path=str_replace(URL::to("/")."/","",$userExist->photo);   
                      if(file_exists($image_path)){  
                        unlink($image_path); //delete
                      }
                    $userExist->update([
                              'photo'=>$image
                     ] );
                      return  response()->json(['message' => 'Photo successfully updated 👍','Photo'=>$userExist],200); 
                }
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

          $Photo=Photo::where("user_id",auth()->user()["id"])->first();
             if(!$Photo)  return response()->json(['message' => 'Sorry this Photo does not belong to you or does not exist⚠️','Photo'=>$Photo],401); 

           $image_path=str_replace(URL::to("/")."/","",$Photo->photo);   
            if(file_exists($image_path)){  
                    unlink($image_path); //delete
              }
          $Photo->delete();
          return response()->json(['message' => 'Photo successfully Deleted 👍','Photo'=>$Photo],200); 
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
        $Photo=Photo::where("user_id",$user_id)->get();
        return response()->json(['message' => 'Photo successfully Loaded 👍','Photo'=>$Photo],200); 
      } catch (\Throwable $th) {
        //   throw $th;
          return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
      }
 }
}