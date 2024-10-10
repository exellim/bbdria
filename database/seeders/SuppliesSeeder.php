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
        // $supplies = [
            // [
            //     'name' => 'Lidocaine Injection',
            //     'branch_id' => $branchId,
            //     'description' => 'Local anesthetic used for numbing.',
            //     'hpp' => 50000, // Bought price
            //     'hjl' => 150000, // Sell price
            //     'stock' => [
            //         'qty' => 50, // Current available stock
            //         'units' => 'ml',
            //         'capacity' => 100,
            //         'reminder' => 10 // Reminder when stock is 10 or below
            //     ]
            // ],
            // $supplies = [
                // Nostril Reduction
        //         [
        //             'name' => 'Nasal Retractor',
        //             'description' => 'Tool used to expose the nostrils during surgery.',
        //             'hjl' => 150000,  // Buy price in IDR
        //             'hpp' => 250000,  // Sell price in IDR
        //             'qty' => 15,      // Stock quantity
        //             'units' => 'piece',
        //             'capacity' => 1,  // Capacity for each unit
        //             'reminder' => 5   // Reminder threshold
        //         ],
        //         // V-line Treatment
        //         [
        //             'name' => 'Jaw Contouring Knife',
        //             'description' => 'Knife used for contouring the jawline.',
        //             'hjl' => 300000,  // Buy price in IDR
        //             'hpp' => 500000,  // Sell price in IDR
        //             'qty' => 8,       // Stock quantity
        //             'units' => 'piece',
        //             'capacity' => 1,  // Capacity for each unit
        //             'reminder' => 4   // Reminder threshold
        //         ],
        //         [
        //             'name' => 'Chin Implant',
        //             'description' => 'Implant used in V-line surgery for chin enhancement.',
        //             'hjl' => 1500000, // Buy price in IDR
        //             'hpp' => 2500000, // Sell price in IDR
        //             'qty' => 12,      // Stock quantity
        //             'units' => 'piece',
        //             'capacity' => 1,  // Capacity for each unit
        //             'reminder' => 2   // Reminder threshold
        //         ],

        //         // Liposuction Double Chin
        //         [
        //             'name' => 'Liposuction Cannula',
        //             'description' => 'Tool used for suctioning fat during double chin liposuction.',
        //             'hjl' => 250000,  // Buy price in IDR
        //             'hpp' => 400000,  // Sell price in IDR
        //             'qty' => 20,      // Stock quantity
        //             'units' => 'piece',
        //             'capacity' => 1,  // Capacity for each unit
        //             'reminder' => 5   // Reminder threshold
        //         ],
        //         [
        //             'name' => 'Compression Garment',
        //             'description' => 'Garment worn after double chin liposuction for recovery.',
        //             'hjl' => 100000,  // Buy price in IDR
        //             'hpp' => 200000,  // Sell price in IDR
        //             'qty' => 30,      // Stock quantity
        //             'units' => 'piece',
        //             'capacity' => 1,  // Capacity for each unit
        //             'reminder' => 10  // Reminder threshold
        //         ]
        // ];

        // foreach ($supplies as $supplyData) {
        //     $supply = Supplies::create([
        //         'branch_id' => $supplyData['branch_id'],
        //         'name' => $supplyData['name'],
        //         'description' => $supplyData['description'],
        //         'hpp' => $supplyData['hpp'],
        //         'hjl' => $supplyData['hjl']
        //     ]);

        //     SuppliesStock::create([
        //         'supply_id' => $supply->id,
        //         'qty' => $supplyData['stock']['qty'], // Current stock
        //         'units' => $supplyData['stock']['units'],
        //         'capacity' => $supplyData['stock']['capacity'],
        //         'reminder' => $supplyData['stock']['reminder'] // Stock reminder
        //     ]);
        // }

        // foreach ($supplies as $supply) {
        //     $createdSupply = Supplies::create([
        //         'branch_id' => 1,
        //         'name' => $supply['name'],
        //         'description' => $supply['description'],
        //         'hjl' => $supply['hjl'],
        //         'hpp' => $supply['hpp'],
        //     ]);

        //     // Store the stock data in SuppliesStock
        //     SuppliesStock::create([
        //         'supply_id' => $createdSupply->id,
        //         'qty' => $supply['qty'],
        //         'units' => $supply['units'],
        //         'capacity' => $supply['capacity'],
        //         'reminder' => $supply['reminder']
        //     ]);
        // }

        $supplies = [
            ['name' => 'Surgical Mask', 'description' => 'Used during operations', 'hjl' => 5000, 'hpp' => 2000, 'qty' => 100, 'units' => 'pcs', 'capacity' => 1, 'reminder' => 20],
            ['name' => 'Sterile Gloves', 'description' => 'Sterile gloves for surgeries', 'hjl' => 15000, 'hpp' => 7000, 'qty' => 200, 'units' => 'pairs', 'capacity' => 1, 'reminder' => 30],
            ['name' => 'Surgical Drapes', 'description' => 'Sterile surgical drapes', 'hjl' => 20000, 'hpp' => 10000, 'qty' => 50, 'units' => 'pcs', 'capacity' => 1, 'reminder' => 10],
            ['name' => 'Sterile Water', 'description' => 'Sterile water for injections', 'hjl' => 10000, 'hpp' => 5000, 'qty' => 60, 'units' => 'bottles', 'capacity' => 1, 'reminder' => 10],
            ['name' => 'Surgical Tape', 'description' => 'Used to hold dressings or tubes in place', 'hjl' => 8000, 'hpp' => 4000, 'qty' => 150, 'units' => 'rolls', 'capacity' => 1, 'reminder' => 20],
            ['name' => 'Face Shield', 'description' => 'Face shield for protection', 'hjl' => 30000, 'hpp' => 15000, 'qty' => 80, 'units' => 'pcs', 'capacity' => 1, 'reminder' => 10],
            ['name' => 'Cotton Pads', 'description' => 'Used for wound dressing', 'hjl' => 5000, 'hpp' => 2500, 'qty' => 300, 'units' => 'pcs', 'capacity' => 10, 'reminder' => 50],
        ];

        foreach ($supplies as $supplyData) {
            $supply = Supplies::create([
                'branch_id' => 1,
                'name' => $supplyData['name'],
                'description' => $supplyData['description'],
                'hjl' => $supplyData['hjl'],
                'hpp' => $supplyData['hpp'],
            ]);

            SuppliesStock::create([
                'supply_id' => $supply->id,
                'qty' => $supplyData['qty'],
                'units' => $supplyData['units'],
                'capacity' => $supplyData['capacity'],
                'reminder' => $supplyData['reminder'],
            ]);
        }
    }
}
