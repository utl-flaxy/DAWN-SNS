<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ユーザー5人を作成し、それぞれに3件の投稿を紐づけて生成
        User::factory(5)
            ->hasPosts(3)
            ->create();
    }
}
