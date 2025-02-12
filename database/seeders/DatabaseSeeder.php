<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\User\Roll;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => '読み込み専用ユーザー',
            'email' => 'reader@example.com',
            'roll_id' => Roll::Reader->value,
        ]);

        User::factory()->create([
            'name' => '編集可能ユーザー',
            'email' => 'editor@example.com',
            'roll_id' => Roll::Editor->value,
        ]);

        $this->call([
            StockSeeder::class,
        ]);
    }
}
