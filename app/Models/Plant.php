<?php

namespace App\Models;

use http\Exception\RuntimeException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_image',
        'name',
        'uuid',
        'status',
        'variety',
        'filial_generation',
        'fatherParent',
        'motherParent',
        'pot_size',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function variety(): BelongsTo
    {
        return $this->belongsTo(Variety::class);
    }

    public function motherParent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'mother_parent');
    }

    public function fatherParent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'father_parent');
    }

    public function getCrossVarietyLabel(): string
    {
        $allRelations = $this->getAllParentRelationships($this);

        /** @var Plant $plant */
        $plantVarietyCount = $varietyNames = [];
        foreach ($allRelations as $plant) {
            if ($plant->variety !== null) {
                $varietyNames[$plant->variety->id] = $plant->variety->name;
                if (isset($plantVarietyCount[$plant->variety->id])) {
                    $plantVarietyCount[$plant->variety->id]++;
                } else {
                    $plantVarietyCount[$plant->variety->id] = 1;
                }
            }
        }

        $origVarietyCount = $plantVarietyCount;
        $varietyCount = count($plantVarietyCount);
        sort($plantVarietyCount);

        if ($varietyCount < 2) {
            //There should be at least 2 varieties otherwise its not a cross
            throw new \LogicException('Something went wrong working out the variety of this cross.');
        }

        $keys = array_keys($varietyNames);
        $totalCount = array_sum($plantVarietyCount);
        $label = "{$origVarietyCount[$keys[0]]}/{$totalCount} {$varietyNames[$keys[0]]} " .
            "{$origVarietyCount[$keys[1]]}/{$totalCount} {$varietyNames[$keys[1]]}";

        $others = $varietyCount - 2;
        if ($others > 0) {
            $label .= "+  $others more";
        }

        return $label;
    }

    private function groupChildrenToSpouses(Collection $allRelatedPlants)
    {
        $plantIds = $allRelatedPlants->pluck('id');

        $potentialSpouses = [];
        foreach ($plantIds as $potentialFatherId) {
            foreach ($plantIds as $potentialMotherId) {
                if ($allRelatedPlants->where('father_parent', $potentialFatherId)->isNotEmpty() &&
                    $allRelatedPlants->where('mother_parent', $potentialMotherId)->isNotEmpty()
                ) {
                    $potentialSpouses[] = [
                        'father' => $potentialFatherId,
                        'mother' => $potentialMotherId
                    ];
                    continue;
                }

                /*
                 * Single Parents
                 */
                if ($allRelatedPlants->where('father_parent', $potentialFatherId)->isEmpty() &&
                    $allRelatedPlants->where('mother_parent', $potentialMotherId)->isNotEmpty()
                ) {
                    $potentialSpouses[] = [
                        'father' => null,
                        'mother' => $potentialMotherId
                    ];

                    $potentialSpouses[] = [
                        'father' => $potentialMotherId,
                        'mother' => $potentialMotherId
                    ];
                    continue;
                }

                if ($allRelatedPlants->where('father_parent', $potentialFatherId)->isNotEmpty() &&
                    $allRelatedPlants->where('mother_parent', $potentialMotherId)->isEmpty()
                ) {
                    $potentialSpouses[] = [
                        'father' => $potentialFatherId,
                        'mother' => null
                    ];

                    $potentialSpouses[] = [
                        'father' => $potentialFatherId,
                        'mother' => $potentialFatherId
                    ];
                }
            }
        }

        $potentialSpouses = array_unique($potentialSpouses, SORT_REGULAR);

        $spouseWithChildren = [];
        foreach ($potentialSpouses as $potentialSpouse) {
            $withMotherAndFather = $allRelatedPlants
                ->where('father_parent', $potentialSpouse['father'])
                ->where('mother_parent', $potentialSpouse['mother']);

            if ($withMotherAndFather->isNotEmpty()) {
                $spouseWithChildren[] = [
                    'parents' => $potentialSpouse,
                    'children' => $withMotherAndFather,
                ];
            }
        }

        return $spouseWithChildren;
    }

    public function familyTreeParents(Plant $plant, $depth = 0, $relationship = '')
    {
        $plantDetails = [
            'name' => $plant->name,
            'class' => $relationship,
            'extra' => [
                'variety' => $plant->variety->name,
                'species' => $plant->variety->species->name,
                'cross_breed' => $plant->crossBreedStatus(),
                'filial_generation' => $plant->filial_generation,
                'status' => $plant->status->name,
                'created' => $plant->created_at->format('Y-m-d'),
                'qr_image' => $plant->qr_image,
                'id' => $plant->id,
            ],
            'depth' => $depth,
            'mother' => null,
            'father' => null,
        ];

        ++$depth;

        if ($plant->fatherParent !== null) {
            $plantDetails['father'] = $this->familyTreeParents($plant->fatherParent, $depth, 'father');
        }

        if ($plant->motherParent !== null && $this->motherParent !== $this->fatherParent) {
            $plantDetails['mother'] = $this->familyTreeParents($plant->motherParent, $depth, 'mother');
        }

        return $plantDetails;
    }

    public function getAllParentRelationships(Plant $plant)
    {
        $relatedPlants = [];
        if ($plant->fatherParent !== null) {
            $relatedPlants[] = $plant->fatherParent;
        }

        if ($plant->motherParent !== $plant->fatherParent && $plant->motherParent !== null) {
            $relatedPlants[] = $plant->motherParent;
        }

        foreach ($relatedPlants as $relatedPlant) {
            $relatedPlants = array_merge($relatedPlants, $this->getAllParentRelationships($relatedPlant));
        }

        return $relatedPlants;
    }

    public function scopeChildren($query)
    {
        return $query->where('mother_parent', $this->id)
            ->orWhere('father_parent', $this->id);
    }

    public function crossBreedStatus()
    {
        if ($this->fatherParent === null && $this->motherParent === null) {
            return 'nonCross';
        }


        if ($this->fatherParent->id === $this->motherParent->id) {
            return 'crossChild';
        }

        if ($this->fatherParent->id !== $this->motherParent->id) {
            return 'newCross';
        }

        throw new \RuntimeException('Invalid cross status: Plant Id: ' . $this->id);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
