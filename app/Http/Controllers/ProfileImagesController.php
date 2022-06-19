<?php

namespace App\Http\Controllers;

use App\Models\ProfileImages;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProfileImagesRequest;
use App\Http\Requests\UpdateProfileImagesRequest;  

class ProfileImagesController extends Controller
{
   public function add()
    { 
      try {      
            if(!auth()->check()){
                return response()->json(['message' => 'Unauthorized ⚠️'], 401);
            }  
                $validator = Validator::make(request()->all(), [
                'photo' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
                'user_id' => 'required|string' 
            ]);

      
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            // create profile picture if there is no picture
            if(request()->hasFile('photo')){
                    $filename = request()->photo->getClientOriginalName();
                    $photo=request()->user_id.$filename;
                    $userExist=ProfileImages::where( "user_id",request()->user_id)->get();   
         
                    if(count( $userExist) >= 5){
                      return response()->json(['message' => 'You should not create more than (5) images in your gallery ,remove some images to create another⚠️',"length"=>count( $userExist),'gallery'=>$userExist],401); 
                    }
               
                      $img =request()->photo->storeAs('gallery',$photo,'public'); //upload  
                      $image=URL::to("storage")."/".$img;
          
                    $ProfileImages = ProfileImages::create([
                                'photo'=>$image,
                            "user_id"=>request()->user_id
                            ] );
                      return response()->json(['message' => 'ProfileImages successfully created 👍',"length"=>count( $userExist),'gallery'=>$ProfileImages],200); 
                    
                }
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
          $ProfileImages=ProfileImages::where("id",$id)
          ->where("user_id",auth()->user()["id"])->delete();
          if(!$ProfileImages)  return response()->json(['message' => 'Sorry this ProfileImages does not belong to you or does not exist⚠️','ProfileImages'=>$ProfileImages],401); 

          return response()->json(['message' => 'ProfileImages successfully Deleted 👍'],200); 

      } catch (\Throwable $th) {
          throw $th;
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
        $ProfileImages=ProfileImages::where("user_id",$user_id)->get();
        return response()->json(['message' => 'ProfileImages successfully Loaded 👍',"length"=>count( $ProfileImages),'ProfileImages'=>$ProfileImages],200); 
      } catch (\Throwable $th) {
        //   throw $th;
          return response()->json([
           'message' => 'This error is from the backend, please contact the backend developer'],500);
        
      }
 }
}