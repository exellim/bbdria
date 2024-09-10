<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Branch::create(['abbreviation'=>'DHS', 'name'=>'Dria Husada', 'address'=>'Jl. Raya Mastrip No.40, Warugunung, Kec. Karangpilang, Surabaya, Jawa Timur 60221', 'mobile'=>'088622324521']);
        Branch::create(['abbreviation'=>'KSB', 'name'=>'Drialogy Deltasari', 'address'=>'Jl. Delta Sari Indah, Koreksari, Kureksari, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur 61256', 'mobile'=>'087833552213']);
    }
}
