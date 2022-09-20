<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RantingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "rate"=>rand(1,5),
            "user_id"=>rand(1,50),
            "rater_id"=>rand(51,100),
            "reviews"=>$this->faker->title,
        ];
    }
}


 