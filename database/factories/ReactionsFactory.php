<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ReactionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "time_to_read" => $this->faker->numberBetween(1, 10),
            "vader" => '"{\"compound\":0.9974,\"neg\":0.007,\"neu\":0.921,\"pos\":0.072}"',
        ];
    }

}
