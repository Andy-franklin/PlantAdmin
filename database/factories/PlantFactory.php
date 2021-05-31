<?php

namespace Database\Factories;

use App\Models\Plant;
use App\Models\Status;
use App\Models\Variety;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->name,
            'status_id' => Status::first()->id,
            'variety_id' => Variety::first()->id,
            'filial_generation' => 0,
            'father_parent' => null,
            'mother_parent' => null,
            'pot_size' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
