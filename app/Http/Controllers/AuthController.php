<?php
namespace App\Http\Controllers; 
use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator; 

class AuthController extends Controller
{
    
    public function signin(Request $request){    
  
    try {
       	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
      
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized ⚠️'], 401);
        }
        $verified=User::where("email",$request->email) 
        ->first(); 
         if (!$verified->email_verified_at) {
           return response()->json(['error' => 'Account not verified ⚠️'], 401);
        }
        return $this->createNewToken($token);
    } catch (\Throwable $th) {
        // throw $th;
    }
    }
    
    public function signup(Request $request) { 

       try {
         $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|between:2,100',
            'lastname' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string|max:14|min:11' ,
            'role' => 'required|string|in:user' 
        ]); 

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $verify_token=rand(1111,9999);
           User::create(array_merge(
                    $validator->validated(),
                    [
                    'password' => bcrypt($request->password),
                    "verify_token"=>$verify_token
                    ]
           ))->profle()->create();
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
        } catch (\Throwable $th) {   
        //    throw $th; 
        return response()->json(['error' => 'Mail was not sent!  check email address and try again ⚠️'], 401); 
    }

        return response()->json([
            'message' => "User successfully registered 👍,  please verify your account 👉 <$request->email>",
        ], 200);
       } catch (\Throwable $th) {
        //    throw $th;
       }
    }

    
    public function signout() {
       try {
       if(!auth()->check()){
          return response()->json(['message' => 'Unauthorized ⚠️'], 401);
       }
       auth()->logout();
        return response()->json(['message' => 'User successfully signed out 👍']);
       } catch (\Throwable $th) {
           //throw $th;
       }
    }
 
    public function refresh() {
      try {
           if(!auth()->check()){
          return response()->json(['message' => 'Unauthorized ⚠️'], 401);
       }
       return $this->createNewToken(Auth::refresh());
      } catch (\Throwable $th) {
          //throw $th;
      }
    }
   
    public function userProfile() { 
     try {
          if(!auth()->check()){
          return response()->json(['message' => 'Unauthorized ⚠️'], 401);
       }
        return response()->json(auth()->user());
     } catch (\Throwable $th) {
         //throw $th;
     }
    }
     
    protected function createNewToken($token){ 
       try {
           return response()->json([
           'message' => 'User successfully signedIn 👍',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
       } catch (\Throwable $th) {
        //    throw $th;
       }    }
}