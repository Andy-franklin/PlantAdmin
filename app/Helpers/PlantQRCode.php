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

        return $this->plant->variety->name .
            ' : F' . $this->plant->filial_generation .
            ' : (' . $createdAt->format('Y-m-d') . ')';
    }

    public function getData()
    {
        return $this->plant->uuid;
    }

    public function getSize()
    {
        return 250;
    }

    public function getMargin()
    {
        return 5;
    }

    public function getFontSize()
    {
        return 10;
    }
}
