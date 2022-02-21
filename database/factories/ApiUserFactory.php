<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApiUser>
 */
class ApiUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_name' => env('BASIC_AUTH_USERNAME'),
            'password' => Hash::make(env('BASIC_AUTH_PASSWORD'))
        ];
    }
}
