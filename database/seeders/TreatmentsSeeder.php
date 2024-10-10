<?php

namespace Database\Seeders;

use App\Models\Treatments;
use App\Models\TreatmentsComponents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $treatments = [
            [
                'name' => 'Buccal Fat Removal',
                'price' => 12000000, // Example price in IDR
                'components' => [
                    ['supply_id' => 1, 'qty' => 1], // Surgical Scissors
                    ['supply_id' => 5, 'qty' => 2], // Sterile Gloves
                    ['supply_id' => 2, 'qty' => 1], // Lidocaine Injection
                    ['supply_id' => 4, 'qty' => 5], // Sterile Gauze Pads
                    ['supply_id' => 6, 'qty' => 1], // Suture Kit
                    ['supply_id' => 5, 'qty' => 2], // Antiseptic Solution
                    ['supply_id' => 12, 'qty' => 1], // Surgical Mask (add to your supplies table)
                    ['supply_id' => 14, 'qty' => 2], // Sterile Drapes (add to your supplies table)
                ],
            ],
            [
                'name' => 'Nostril Reduction',
                'price' => 9000000, // Example price in IDR
                'components' => [
                    ['supply_id' => 2, 'qty' => 1],  // Lidocaine Injection
                    ['supply_id' => 6, 'qty' => 2],  // Absorbable Sutures
                    ['supply_id' => 16, 'qty' => 1], // Surgical Tape (add to your supplies table)
                    ['supply_id' => 18, 'qty' => 10], // Cotton Balls (add to your supplies table)
                ],
            ],
            [
                'name' => 'V-line Treatment',
                'price' => 15000000, // Example price in IDR
                'components' => [
                    ['supply_id' => 9, 'qty' => 1],  // Chin Implant
                    ['supply_id' => 2, 'qty' => 5],  // Lidocaine Injection (General/Local)
                    ['supply_id' => 5, 'qty' => 3],  // Sterile Gloves
                    ['supply_id' => 6, 'qty' => 2],  // Suture Kit
                ],
            ],
            [
                'name' => 'Liposuction Double Chin',
                'price' => 17000000, // Example price in IDR
                'components' => [
                    ['supply_id' => 10, 'qty' => 1], // Liposuction Cannula
                    ['supply_id' => 5, 'qty' => 2],  // Sterile Gloves
                    ['supply_id' => 4, 'qty' => 5],  // Sterile Gauze Pads
                    ['supply_id' => 14, 'qty' => 2], // Sterile Drapes
                ],
            ],
        ];

        // Insert treatment data
        foreach ($treatments as $treatmentData) {
            $treatment = Treatments::create([
                'branch_id' => 1, // Example branch_id
                'name' => $treatmentData['name'],
                'price' => $treatmentData['price'],
            ]);

            // Insert related components
            foreach ($treatmentData['components'] as $component) {
                TreatmentsComponents::create([
                    'treatment_id' => $treatment->id,
                    'supply_id' => $component['supply_id'],
                    'qty' => $component['qty'],
                ]);
            }
        }
    }
}
