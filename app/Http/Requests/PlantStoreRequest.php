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
            'crossBreedingInfo' => ['required'],
            'father_parent_id' => ['nullable', 'exists:plants,id'],
            'mother_parent_id' => ['nullable', 'exists:plants,id'],
            'parent_plant_id' => ['nullable', 'exists:plants,id'],
            'quantity' => ['nullable', 'integer'],
            'pot_size' => ['nullable', 'integer'],
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes(['father_parent_id', 'mother_parent_id'], 'required', static function ($input) {
            return $input->crossBreedingInfo === 'newCross';
        });

        $validator->sometimes(['parent_plant_id'], 'required', static function ($input) {
            return $input->crossBreedingInfo === 'crossChild';
        });

        return $validator;
    }

    public function store(): array
    {
        $validated = $this->validated();

        $count = $validated['quantity'] ?? 1;

        $plants = [];

        $variety = Variety::findOrFail($validated['variety_id']);
        $status = Status::findOrFail($validated['status_id']);

        $fatherPlant = $motherPlant = null;
        if ($validated['crossBreedingInfo'] === 'crossChild') {
            $validated['father_parent_id'] = $validated['mother_parent_id'] = $validated['parent_plant_id'];
        }

        if (isset($validated['father_parent_id'])) {
            $fatherPlant = Plant::findOrFail($validated['father_parent_id']);
        }
        if (isset($validated['father_parent_id'])) {
            $motherPlant = Plant::findOrFail($validated['mother_parent_id']);
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
