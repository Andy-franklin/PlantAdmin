<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            ['name' => 'Front Garden'],
            ['name' => 'Back Garden'],
            ['name' => 'Master Bedroom'],
            ['name' => 'Stairs'],
            ['name' => 'Office'],
            ['name' => 'Spare Bedroom'],
            ['name' => 'Living Room'],
        ]);
    }
}
