<?php

namespace Database\Seeders;

use App\Models\User;
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
        $it = User::create([
            'id' => '1',
            'username' => 'itsupport',
            'name' => 'Exelensi Christian',
            'email' => 'exel.lim@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('exel12345'), // Change 'password' to a stronger one in production
        ]);
        $it->assignRole('master');
    }
}
