<?php

namespace App\Helpers;

use App\Models\Plant;

class PlantQRCode implements QRCode
{
    private $plant;

    /**
     * PlantQRCode constructor.
     */
    public function __construct(Plant $plant)
    {
        $this->plant = $plant;
    }

    public function getLabel()
    {
        $createdAt = $this->plant->created_at ?? now();

        if ($this->plant->variety === null) {
            $variety = $this->plant->getCrossVarietyLabel();
        } else {
            $variety = $this->plant->variety->name;
        }

        return $variety .
            ' : F' . $this->plant->filial_generation .
            ' : (' . $createdAt->format('Y-m-d') . ')';
    }

    public function getData()
    {
        return $this->plant->uuid;
    }

    public function getSize()
    {
        return 200;
    }

    public function getMargin()
    {
        return 5;
    }

    public function getFontSize()
    {
        return 6;
    }
}
