<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "firstname" => $this->faker->name(),
            "lastname" => $this->faker->name(),
            "title" => $this->faker->word(),
            "email" => $this->faker->email(),
            "gender" => Str::ucfirst($this->faker->randomElement(['male', 'female'])),
            "company" => $this->faker->company(),
            "city" => $this->faker->city(),
            "longitude" => $this->faker->randomFloat() ?? null,
            "latitude" => $this->faker->randomFloat() ?? null,
        ];
    }
}
