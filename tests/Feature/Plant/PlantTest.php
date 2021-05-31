<?php

namespace Plant;

use App\Models\Plant;
use App\Models\Status;
use App\Models\Variety;
use Tests\TestCase;

class PlantTest extends TestCase
{
    /**
     * @test
     */
    public function options_for_the_create_plant_form_are_shown()
    {
        $plant = Plant::factory()->create();

        $this->options(route('plant.create.form'))
            ->assertStatus(200)
            ->assertJson([
                'statuses' => [
                    '1' => 'Planning',
                    '2' => 'Germinating',
                    '3' => 'Germinated',
                    '4' => 'Potted',
                    '5' => 'Planted',
                    '6' => 'Deceased',
                ],
                'plants' => [
                    [
                        'id' => $plant->id,
                        'name' => $plant->name,
                        'created_at' => $plant->created_at->toJson(),
                    ]
                ],
                'species' => [
                    '1' => 'Capsicum Annuum',
                    '2' => 'Capsicum Baccatum',
                ],
                'varieties' => [
                    '1' => 'Cayenne',
                    '2' => 'Demon Red',
                    '3' => 'Anaheim',
                    '4' => "Jalapeño",
                    '5' => 'Spangles',
                ],
            ]);
    }

    /**
     * @test
     */
    public function a_plant_can_be_created()
    {
        $this->postJson(route('plant.create.store'), [
            'name' => 'Jalapeno 1',
            'status_id' => Status::first()->id,
            'variety_id' => Variety::first()->id,
            'filial_generation' => 0,
            'father_parent' => Plant::factory()->create()->id,
            'mother_parent' => Plant::factory()->create()->id,
        ]);

        $this->assertDatabaseHas('plants', [
            'name' => 'Jalapeno 1'
        ]);

        $count = Plant::query()->where('name', 'Jalapeno 2')->count();
        self::assertSame(0, $count);

        $this->postJson(route('plant.create.store'), [
            'name' => 'Jalapeno 2',
            'status_id' => Status::first()->id,
            'variety_id' => Variety::first()->id,
            'filial_generation' => 0,
            'father_parent' => Plant::factory()->create()->id,
            'mother_parent' => Plant::factory()->create()->id,
            'quantity' => 5
        ]);

        $count = Plant::query()->where('name', 'Jalapeno 2')->count();
        self::assertSame(5, $count);
    }
}
