<?php

namespace Database\Factories;

use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MahasiswaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public static $counter = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $usernameAndPassword = "mahasiswa_" . static::$counter++;

        return [
            'name' => $this->faker->name,
            'username' => $usernameAndPassword,
            'level' => $this->faker->randomElement([User::LEVEL_MAHASISWA]),
            'remember_token' => Str::random(10),
            'password' => Hash::make($usernameAndPassword)
        ];
    }
}
