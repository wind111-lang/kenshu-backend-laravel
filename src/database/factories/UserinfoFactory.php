<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\UserInfo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserinfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static ?string $password;
    protected $model = UserInfo::class;
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'username'=> fake()->name(),
            'password' => static::$password ??= Hash::make('password'),
            'user_image' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
