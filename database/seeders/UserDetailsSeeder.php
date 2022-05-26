<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
           DB::table('users')->insert( ['name' => "Admin",
            'email' => "admin@gmail.com",
            'email_verified_at' => now(),
            'phone' => "09024195493",
            'role'=>"admin",
            'password' =>bcrypt("admin@2022"),  
            'remember_token' => Str::random(10) ]);
    
    }

    //seller email:websoftLTD@gmail.com  password:password123
    //buyer email: buyer@gmail.com ,password:password123
   
}