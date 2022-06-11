<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyController extends Controller
{
     public function verify($token,$email){
          try {
             dd($token,$email);
          } catch (\Throwable $th) {
              //throw $th;
          }
     }
     public function resend(){
      try {
          //code...
      } catch (\Throwable $th) {
          //throw $th;
      }
     }
}