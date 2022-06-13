<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\CardDetailsController;

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

//  Card Details 
 Route::group([ 
    'prefix' => 'card'
], function ($router) {
    Route::post('/add', [CardDetailsController::class, 'add']);
    Route::delete('/remove/{id}', [CardDetailsController::class, 'remove']);
    Route::get('/get', [CardDetailsController::class, 'get']);
 });

 //Bank Details
 Route::group([ 
    'prefix' => 'bank'
], function ($router) {
    Route::post('/add', [BankDetailsController::class, 'add']);
    Route::delete('/remove/{id}', [BankDetailsController::class, 'remove']);
    Route::get('/get', [BankDetailsController::class, 'get']);
 });

 //TODO:content of mails and design .......
 //TODO:Stop unverified users from login in
 //TODO:Reset Password/send reset link