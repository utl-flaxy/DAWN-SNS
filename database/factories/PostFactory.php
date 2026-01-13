<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // 投稿者（ユーザー）を自動生成
            'content' => $this->faker->realText(80), // 80文字くらいの文章
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
