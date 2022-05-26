<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // admin
        return [ 
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'email_verified_at' => now(),
            'phone' => "09024195493",
            'role'=>"admin",
            'password' =>bcrypt("admin@2022"),  
            'remember_token' => Str::random(10) 
        ];
    }

    //seller email:websoftLTD@gmail.com  password:password123
    //buyer email: buyer@gmail.com ,password:password123
}