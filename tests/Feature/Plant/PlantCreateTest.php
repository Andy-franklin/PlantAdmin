<?php

namespace Plant;

use App\Models\Plant;
use App\Models\Status;
use App\Models\Variety;
use Tests\TestCase;

class PlantCreateTest extends TestCase
{
    /**
     * @test
     */
    public function options_for_the_create_plant_form_are_shown()
    {
        $plant = Plant::factory()->create();

        $cayenne = Variety::query()->where('name', 'Cayenne')->first();
        $demonRed = Variety::query()->where('name', 'Demon Red')->first();
        $anaheim = Variety::query()->where('name', 'Anaheim')->first();
        $jalapeno = Variety::query()->where('name', 'Jalapeño')->first();
        $spangles = Variety::query()->where('name', 'Spangles')->first();


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
                    [
                        'name' => 'Cayenne',
                        'id' => $cayenne->id,
                        'species_id' => $cayenne->species_id,
                    ],
                    [
                        'name' => 'Demon Red',
                        'id' => $demonRed->id,
                        'species_id' => $demonRed->species_id,
                    ],
                    [
                        'name' => 'Anaheim',
                        'id' => $anaheim->id,
                        'species_id' => $anaheim->species_id,
                    ],
                    [
                        'name' => "Jalapeño",
                        'id' => $jalapeno->id,
                        'species_id' => $jalapeno->species_id,
                    ],
                    [
                        'name' => 'Spangles',
                        'id' => $spangles->id,
                        'species_id' => $spangles->species_id,
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function a_plant_can_be_created_as_a_new_cross()
    {
        $varities = Variety::all()->toArray();

        $this->postJson(route('plant.create.store'), [
            'crossBreedingInfo' => 'newCross',
            'name' => 'Jalapeno new 1',
            'status_id' => Status::first()->id,
            'filial_generation' => 0,
            'father_parent_id' => Plant::factory()->create()->id,
            'mother_parent_id' => Plant::factory()->create([
                'variety_id' => end($varities)['id']
            ])->id,
        ]);

        $this->assertDatabaseHas('plants', [
            'name' => 'Jalapeno new 1'
        ]);

        $count = Plant::query()->where('name', 'Jalapeno new 2')->count();
        self::assertSame(0, $count);

        $this->postJson(route('plant.create.store'), [
            'crossBreedingInfo' => 'newCross',
            'name' => 'Jalapeno new 2',
            'status_id' => Status::first()->id,
            'filial_generation' => 0,
            'father_parent_id' => Plant::factory()->create()->id,
            'mother_parent_id' => Plant::factory()->create([
                'variety_id' => end($varities)['id']
            ])->id,
            'quantity' => 5
        ]);

        $count = Plant::query()->where('name', 'Jalapeno new 2')->count();
        self::assertSame(5, $count);
    }

    /**
     * @test
     */
    public function a_plant_can_be_created_as_a_cross_child()
    {
        $this->postJson(route('plant.create.store'), [
            'crossBreedingInfo' => 'crossChild',
            'status_id' => Status::first()->id,
            'name' => 'Jalapeno cross child',
            'filial_generation' => 0,
            'parent_plant_id' => Plant::factory()->create()->id,
        ]);

        $this->assertDatabaseHas('plants', [
            'name' => 'Jalapeno cross child'
        ]);

        $count = Plant::query()->where('name', 'Jalapeno cross child2')->count();
        self::assertSame(0, $count);

        $res = $this->postJson(route('plant.create.store'), [
            'crossBreedingInfo' => 'crossChild',
            'status_id' => Status::first()->id,
            'name' => 'Jalapeno cross child2',
            'filial_generation' => 0,
            'parent_plant_id' => Plant::factory()->create()->id,
            'quantity' => 5
        ]);

        $count = Plant::query()->where('name', 'Jalapeno cross child2')->count();
        self::assertSame(5, $count);
    }

    /**
     * @test
     */
    public function a_plant_can_be_created_as_a_non_cross()
    {
        $this->postJson(route('plant.create.store'), [
            'crossBreedingInfo' => 'nonCross',
            'status_id' => Status::first()->id,
            'variety_id' => Variety::first()->id,
            'name' => 'Jalapeno non cross',
            'filial_generation' => 0,
        ]);

        $this->assertDatabaseHas('plants', [
            'name' => 'Jalapeno non cross'
        ]);

        $count = Plant::query()->where('name', 'Jalapeno non cross2')->count();
        self::assertSame(0, $count);

        $res = $this->postJson(route('plant.create.store'), [
            'crossBreedingInfo' => 'nonCross',
            'status_id' => Status::first()->id,
            'variety_id' => Variety::first()->id,
            'name' => 'Jalapeno non cross2',
            'filial_generation' => 0,
            'quantity' => 5
        ]);

        $count = Plant::query()->where('name', 'Jalapeno non cross2')->count();
        self::assertSame(5, $count);
    }
}
