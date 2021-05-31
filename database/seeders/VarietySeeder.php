<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VarietySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('varieties')->insert([
            [
                'name' => 'Cayenne',
                'species_id' => Species::query()->where('name', '=', 'Capsicum Annuum')->pluck('id')->first()
            ],
            [
                'name' => 'Demon Red',
                'species_id' => Species::query()->where('name', '=', 'Capsicum Annuum')->pluck('id')->first()
            ],
            [
                'name' => 'Anaheim',
                'species_id' => Species::query()->where('name', '=', 'Capsicum Annuum')->pluck('id')->first()
            ],
            [
                'name' => 'Jalapeño',
                'species_id' => Species::query()->where('name', '=', 'Capsicum Annuum')->pluck('id')->first()
            ],
            [
                'name' => 'Spangles',
                'species_id' => Species::query()->where('name', '=', 'Capsicum Baccatum')->pluck('id')->first()
            ],
        ]);
    }
}
