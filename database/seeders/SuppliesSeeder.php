<?php

namespace Database\Seeders;

use App\Models\Supplies;
use App\Models\SuppliesStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class SuppliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $branchId = 1;
        $supplies = [
            [
                'name' => 'Lidocaine Injection',
                'branch_id' => $branchId,
                'description' => 'Local anesthetic used for numbing.',
                'hpp' => 50000, // Bought price
                'hjl' => 150000, // Sell price
                'stock' => [
                    'qty' => 50, // Current available stock
                    'units' => 'ml',
                    'capacity' => 100,
                    'reminder' => 10 // Reminder when stock is 10 or below
                ]
            ],
            [
                'name' => 'Surgical Knife',
                'branch_id' => $branchId,
                'description' => 'Used for making incisions during surgeries.',
                'hpp' => 200000, // Bought price
                'hjl' => 400000, // Sell price
                'stock' => [
                    'qty' => 10, // Current available stock
                    'units' => 'pcs',
                    'capacity' => 20,
                    'reminder' => 5 // Reminder when stock is 5 or below
                ]
            ],
            [
                'name' => 'Sterile Gauze',
                'branch_id' => $branchId,
                'description' => 'Used for wound dressing and cleaning.',
                'hpp' => 10000, // Bought price
                'hjl' => 25000, // Sell price
                'stock' => [
                    'qty' => 250, // Current available stock
                    'units' => 'pcs',
                    'capacity' => 500,
                    'reminder' => 50 // Reminder when stock is 50 or below
                ]
            ],
            [
                'name' => 'Antiseptic Solution',
                'branch_id' => $branchId,
                'description' => 'Used for cleaning the surgical area.',
                'hpp' => 30000, // Bought price
                'hjl' => 75000, // Sell price
                'stock' => [
                    'qty' => 25, // Current available stock
                    'units' => 'ml',
                    'capacity' => 50,
                    'reminder' => 10 // Reminder when stock is 10 or below
                ]
            ],
            [
                'name' => 'Suture Thread',
                'branch_id' => $branchId,
                'description' => 'Used for stitching wounds after surgery.',
                'hpp' => 50000, // Bought price
                'hjl' => 120000, // Sell price
                'stock' => [
                    'qty' => 100, // Current available stock
                    'units' => 'pcs',
                    'capacity' => 150,
                    'reminder' => 30 // Reminder when stock is 30 or below
                ]
            ]
        ];

        foreach ($supplies as $supplyData) {
            $supply = Supplies::create([
                'branch_id' => $supplyData['branch_id'],
                'name' => $supplyData['name'],
                'description' => $supplyData['description'],
                'hpp' => $supplyData['hpp'],
                'hjl' => $supplyData['hjl']
            ]);

            SuppliesStock::create([
                'supply_id' => $supply->id,
                'qty' => $supplyData['stock']['qty'], // Current stock
                'units' => $supplyData['stock']['units'],
                'capacity' => $supplyData['stock']['capacity'],
                'reminder' => $supplyData['stock']['reminder'] // Stock reminder
            ]);
        }

    }
}
