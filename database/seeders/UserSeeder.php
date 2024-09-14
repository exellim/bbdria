<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UsersBranch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // User::create([
        //     'id' => '1',
        //     'username' => 'itsupport',
        //     'name' => 'Exelensi Christian',
        //     'email' => 'exel.lim@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('exel12345'), // Change 'password' to a stronger one in production
        // ])->assignRole('master');

        // Seed 5 doctors
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'username' => 'doctor' . $i,
                'name' => 'Dr. Doctor Name ' . $i, // Add 'Dr.' in front of their names
                'email' => 'doctor' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('doctor' . $i),
            ])->assignRole('doctor');

            // Assign the branch (branch_id = 1 for this example)
            UsersBranch::create([
                'user_id' => $user->id,
                'branch_id' => 1,
            ]);
        }

        // Seed 6 assistants
        for ($i = 1; $i <= 6; $i++) {
            $user = User::create([
                'username' => 'assistant' . $i,
                'name' => 'Assistant Name ' . $i,
                'email' => 'assistant' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('assistant' . $i),
            ])->assignRole('assistant');

            // Assign the branch
            UsersBranch::create([
                'user_id' => $user->id,
                'branch_id' => 1,
            ]);
        }

        // Seed 4 beauticians
        for ($i = 1; $i <= 4; $i++) {
            $user = User::create([
                'username' => 'beautician' . $i,
                'name' => 'Beautician Name ' . $i,
                'email' => 'beautician' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('beautician' . $i),
            ])->assignRole('beautician');

            // Assign the branch
            UsersBranch::create([
                'user_id' => $user->id,
                'branch_id' => 1,
            ]);
        }
    }
}
