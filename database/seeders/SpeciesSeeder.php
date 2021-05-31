<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('species')->insert([
            ['name' => 'Capsicum Annuum'],
            ['name' => 'Capsicum Baccatum'],
        ]);
    }
}
