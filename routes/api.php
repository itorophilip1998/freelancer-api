<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RantingController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\CardDetailsController;
use App\Http\Controllers\ProfileImagesController;
use App\Http\Controllers\SpecialEquipmentController; 

//  Auth route
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/signout', [AuthController::class, 'signout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'userProfile']);       
}); 

 //  Verify route
Route::group([
    'middleware' => 'api',
    'prefix' => 'verify'
], function ($router) { 
    Route::get('/{token}/{email}', [VerifyController::class, 'verify']);    
    Route::post('/resend', [VerifyController::class, 'resend']);    
}); 

 //  Password route
Route::group([
    'middleware' => 'api',
    'prefix' => 'password'
], function ($router) { 
    Route::post('/send-reset-link', [PasswordController::class, 'sendReset']);     
    Route::post('/reset', [PasswordController::class, 'reset']);    
}); 

//  User Profile route
Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function ($router) {
    Route::post('/update/{user_id}', [UserController::class, 'updateUser']);   
    Route::get('/get/{user_id}', [UserController::class, 'getUser']);   
}); 

//  Update Profile route
Route::group([
    'middleware' => 'api',
    'prefix' => 'profile'
], function ($router) {
    Route::post('/update/{user_id}', [ProfileController::class, 'updateProfile']);   
    Route::get('/get/{user_id}', [ProfileController::class, 'getProfile']);   
});

//  Upload Profile Image  Details 
 Route::group([ 
    'prefix' => 'photo'
], function ($router) {
    Route::post('/add', [ProfileImagesController::class, 'add']);
    Route::delete('/remove/{id}', [ProfileImagesController::class, 'remove']);
    Route::get('/get/{user_id}', [ProfileImagesController::class, 'get']);
 });
 
//  Skills Details 
 Route::group([ 
    'prefix' => 'skills'
], function ($router) {
    Route::post('/add', [SkillController::class, 'add']);
    Route::delete('/remove/{id}', [SkillController::class, 'remove']);
    Route::get('/get/{user_id}', [SkillController::class, 'get']);
 });
 
//  Special Equipment Details 
 Route::group([ 
    'prefix' => 'equipment'
], function ($router) {
    Route::post('/add', [SpecialEquipmentController::class, 'add']);
    Route::delete('/remove/{id}', [SpecialEquipmentController::class, 'remove']);
    Route::get('/get/{skill_id}', [SpecialEquipmentController::class, 'get']);
 });
 
 //  Rating Details 
 Route::group([ 
    'prefix' => 'rating'
], function ($router) {
    Route::post('/add', [RantingController::class, 'add']);
    Route::delete('/remove/{id}', [RantingController::class, 'remove']);
    Route::get('/get/{user_id}', [RantingController::class, 'get']);
 });

//  Card Details 
 Route::group([ 
    'prefix' => 'card'
], function ($router) {
    Route::post('/add', [CardDetailsController::class, 'add']);
    Route::delete('/remove/{id}', [CardDetailsController::class, 'remove']);
    Route::get('/get/{user_id}', [CardDetailsController::class, 'get']);
 });

 //Bank Details
 Route::group([ 
    'prefix' => 'bank'
], function ($router) {
    Route::post('/add', [BankDetailsController::class, 'add']);
    Route::delete('/remove/{id}', [BankDetailsController::class, 'remove']);
    Route::get('/get/{user_id}', [BankDetailsController::class, 'get']);
 });
   
   //TODO:bug on server card/bank details ---done
    //update/get that belongs to a user=>user  ---done 
    // update/get  that belongs to a user=>profile --done 
    //update/delete/get that belongs to  a user => skill --done 
    //update/delete/get that belongs to  a user => equipment --done 
    //update/delete/get that belongs to a user => rating --done
    
      // update/get/remove  that belongs to a user=>profile_images --doing
    
 //TODO:Search query user by queris and sort and relations  
   // update/get/remove  that belongs to a user=>image galery
   //bug in rating and rater id while updating and creating
    // work on rating review --fixed-not-tested