<?php
namespace App\Http\Controllers;
use Validator;
use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct() {
    //     $this->middleware('auth:api', ['except' => ['signup', 'signin']]);
    // }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request){  
            
    //     Mail::send('emails.welcome', $request->all(), function ($message) use ($request) {
    //     $message->to($request)
    //         ->subject('Welcome to Cassava')
    //         ->from("itorophilip1998@gmail.com", 'Cassava.com');
    // });
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
        return $this->createNewToken($token);
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request) { 

       try {
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string|max:14|min:11' ,
            'role' => 'required|string|in:seller,buyer' ,
            'business_type' => 'requiredIf:role,seller|string|in:individual,company' ,
            "address"=>"excludeIf:role,buyer|requiredIf:role,seller",
            "city"=>"excludeIf:role,buyer|requiredIf:role,seller"
        ]);
       

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered,  please verify your email 👍',
            'user' => $user
        ], 200);
       } catch (\Throwable $th) {
           throw $th;
       }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
      try {
           if(!auth()->check()){
          return response()->json(['message' => 'Unauthorized ⚠️'], 401);
       }
       return $this->createNewToken(auth()->refresh());
      } catch (\Throwable $th) {
          //throw $th;
      }
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){ 
       try {
           return response()->json([
           'message' => 'User successfully signedIn 👍',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
       } catch (\Throwable $th) {
        //    throw $th;
       }    }
}