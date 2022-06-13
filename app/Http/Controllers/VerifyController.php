<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VerifyController extends Controller
{
     public function verify($token,$email){
          try {
             $user=User::where("verify_token",$token)
             ->where("email",$email)
             ->first();
            if(!$user){
                return response()->json(['error' => 'This user does not exist or incorrect token, Resend mail notification ⚠️'], 401);  
                } 
               
             $user->update(["email_verified_at"=>now()]); 
              return response()->json([
            'message' => "Your account was successfully verified👉 <$email>",
        ], 200);
          } catch (\Throwable $th) {
            //   throw $th;
          }
     }
     public function resend(Request $request){
      try {
        $verify_token=rand(1111,9999);

         $validator = Validator::make(request()->all(), [ 
            'email' => 'required|string|email|max:100', 
        ]);
         if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user=User::where('email',$request->email)->first();
        if(!$user){
        return response()->json(['error' => 'This user does not exist⚠️'], 401);  
        }
          $user->update(["verify_token"=>$verify_token]);
           $uri=URL::to("/api/verify/$verify_token/$request->email"); 
        
           $mail_data=[
            "subject"=>"Welcome to Freelancer",
            "view"=>"emails.welcome",
            "main"=>request()->all(),
            "link"=>"$uri",
            "token"=>"$verify_token"
        ];
        try { 
            Mail::to(request()->email)->send(new SendMail($mail_data));
          return response()->json([
            'message' => "A verification link has been sent to your account 👉 <$request->email>",
        ], 200);
        } catch (\Throwable $th) {   
        //    throw $th; 
        return response()->json(['error' => 'Mail was not sent!  check email address and try again ⚠️'], 401); 
    }
      } catch (\Throwable $th) {
        //   throw $th;
      }
     }
}