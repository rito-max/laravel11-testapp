<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Transaction;


class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //リレーションデータあり
        Stock::factory()
            ->count(16)
            ->has(Transaction::factory()->count(3))
            ->create();

        //リレーションなし
        Stock::factory()
            ->count(3)
            ->create();
    }
}
