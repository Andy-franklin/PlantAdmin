<?php

namespace App\Http\Requests;

use App\Helpers\PlantQRCode;
use App\Helpers\QRCodeHelper;
use App\Models\Plant;
use App\Models\Status;
use App\Models\Variety;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PlantStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'status_id' => ['required', 'exists:statuses,id'],
            'variety_id' => ['required', 'exists:varieties,id'],
            'filial_generation' => ['required', 'integer', 'gte:0'],
            'father_parent' => ['exists:plants,id'],
            'mother_parent' => ['exists:plants,id'],
            'parent_plant' => ['exists:plants,id'],
            'quantity' => ['integer'],
            'pot_size' => ['integer'],
        ];
    }

    public function store(): array
    {
        $validated = $this->validated();

        $count = $validated['quantity'] ?? 1;

        $plants = [];

        $variety = Variety::findOrFail($validated['variety_id']);
        $status = Status::findOrFail($validated['status_id']);

        $fatherPlant = $motherPlant = null;
        if (isset($validated['father_parent'])) {
            $fatherPlant = Plant::findOrFail($validated['father_parent']);
        }
        if (isset($validated['mother_parent'])) {
            $motherPlant = Plant::findOrFail($validated['mother_parent']);
        }

        for ($i = 0; $i < $count; $i++) {
            /** @var Plant $plant */
            $plant = Plant::make([
                'uuid' => Str::uuid(),
                'name' => $validated['name'],
                'filial_generation' => $validated['filial_generation'],
            ]);

            $plant->variety()->associate($variety);
            $plant->status()->associate($status);

            if ($fatherPlant !== null) {
                $plant->fatherParent()->associate($fatherPlant);
            }

            if ($motherPlant !== null) {
                $plant->motherParent()->associate($motherPlant);
            }

            $plant->qr_image = QRCodeHelper::generateQRCode(new PlantQRCode($plant));

            $plant->save();

            $plants[] = $plant;
        }

        return $plants;
    }
}
