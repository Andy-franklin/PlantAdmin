<?php

namespace Plant;

use App\Models\Plant;
use Tests\TestCase;

class PlantFamilyTreeTest extends TestCase
{
    /**
     * @test
     */
    public function a_family_tree_of_a_plant_can_be_seen()
    {
        $plant = Plant::factory()->create([
            'name' => 'plant One',
            'father_parent' => Plant::factory()->create([
                'name' => 'plant Two',
                'father_parent' => Plant::factory()->create([
                    'name' => 'plant Three',
                ]),
                'mother_parent' => Plant::factory()->create([
                    'name' => 'plant Four',
                    'father_parent' => Plant::factory()->create([
                        'name' => 'plant Five',
                    ]),
                    'mother_parent' => Plant::factory()->create([
                        'name' => 'plant Six',
                    ])
                ])
            ]),
            'mother_parent' => Plant::factory()->create([
                'name' => 'plant Seven',
                'father_parent' => Plant::factory()->create([
                    'name' => 'plant Eight',
                    'father_parent' => Plant::factory()->create([
                        'name' => 'plant Nine',
                    ]),
                    'mother_parent' => Plant::factory()->create([
                        'name' => 'plant Ten',
                    ])
                ]),
            ])
        ]);

        $expected = [
            'name' => 'plant One',
            'class' => '',
            'extra' => [
                'variety' => 'Cayenne',
                'filial_generation' => 0,
                'id' => Plant::query()->where('name', 'plant One')->first()->id,
            ],
            'depth' => 0,
            'mother' => [
                'name' => 'plant Seven',
                'class' => 'mother',
                'extra' => [
                    'variety' => 'Cayenne',
                    'filial_generation' => 0,
                    'id' => Plant::query()->where('name', 'plant Seven')->first()->id,
                ],
                'depth' => 1,
                'mother' => null,
                'father' => [
                    'name' => 'plant Eight',
                    'class' => 'father',
                    'extra' => [
                        'variety' => 'Cayenne',
                        'filial_generation' => 0,
                        'id' => Plant::query()->where('name', 'plant Eight')->first()->id,
                    ],
                    'depth' => 2,
                    'mother' => [
                        'name' => 'plant Ten',
                        'class' => 'mother',
                        'extra' => [
                            'variety' => 'Cayenne',
                            'filial_generation' => 0,
                            'id' => Plant::query()->where('name', 'plant Ten')->first()->id,
                        ],
                        'depth' => 3,
                        'mother' => null,
                        'father' => null,
                    ],
                    'father' => [
                        'name' => 'plant Nine',
                        'class' => 'father',
                        'extra' => [
                            'variety' => 'Cayenne',
                            'filial_generation' => 0,
                            'id' => Plant::query()->where('name', 'plant Nine')->first()->id,
                        ],
                        'depth' => 3,
                        'mother' => null,
                        'father' => null,
                    ]
                ],
            ],
            'father' => [
                'name' => 'plant Two',
                'class' => 'father',
                'extra' => [
                    'variety' => 'Cayenne',
                    'filial_generation' => 0,
                    'id' => Plant::query()->where('name', 'plant Two')->first()->id,
                ],
                'depth' => 1,
                'mother' => [
                    'name' => 'plant Four',
                    'class' => 'mother',
                    'extra' => [
                        'variety' => 'Cayenne',
                        'filial_generation' => 0,
                        'id' => Plant::query()->where('name', 'plant Four')->first()->id,
                    ],
                    'depth' => 2,
                    'mother' => [
                        'name' => 'plant Six',
                        'class' => 'mother',
                        'extra' => [
                            'variety' => 'Cayenne',
                            'filial_generation' => 0,
                            'id' => Plant::query()->where('name', 'plant Six')->first()->id,
                        ],
                        'depth' => 3,
                        'mother' => null,
                        'father' => null,
                    ],
                    'father' => [
                        'name' => 'plant Five',
                        'class' => 'father',
                        'extra' => [
                            'variety' => 'Cayenne',
                            'filial_generation' => 0,
                            'id' => Plant::query()->where('name', 'plant Five')->first()->id,
                        ],
                        'depth' => 3,
                        'mother' => null,
                        'father' => null,
                    ],
                ],
                'father' => [
                    'name' => 'plant Three',
                    'class' => 'father',
                    'extra' => [
                        'variety' => 'Cayenne',
                        'filial_generation' => 0,
                        'id' => Plant::query()->where('name', 'plant Three')->first()->id,
                    ],
                    'depth' => 2,
                    'mother' => null,
                    'father' => null,
                ],
            ],
        ];

        $familyTree = $plant->familyTreeParents($plant);

        self::assertSame($expected, $familyTree);

        $res = $this->get(route('plant.family-tree', ['plant' => Plant::query()->where('name', 'plant One')->first()->id]));

        $res->assertStatus(200)
            ->assertJson($expected);
    }
}
