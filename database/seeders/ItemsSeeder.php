<?php

namespace Database\Seeders;

use App\Models\Items;
use App\Models\ItemsStock;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 25; $i++) {
            // Create a new item in the Items model
            $item = Items::create([
                'category_id' => 1,
                'branch_id' => 1,
                'name' => 'Item ' . $i,
                'descriptions' => 'This is a description for item ' . $i,
                'expiry_date' => Carbon::now()->addMonths(rand(1, 24))->format('Y-m-d'),
                'hjl' => rand(100000, 500000), // Random value for hjl in IDR
                'hpp' => rand(50000, 300000), // Random value for hpp in IDR
                'image' => null, // Set image as null
            ]);

            // Create corresponding stock in the ItemsStock model
            ItemsStock::create([
                'item_id' => $item->id,
                'qty' => rand(10, 100), // Random quantity for stock
            ]);
        }
    }
}
