<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Address::class;

    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'user_id' => \App\Models\User::factory(),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
