<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantStoreRequest;
use App\Models\plant;
use App\Models\Species;
use App\Models\Status;
use App\Models\Variety;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        return new JsonResponse([
            'statuses' => Status::query()->pluck('name', 'id'),
            'plants' => Plant::query()->select(['id', 'name', 'created_at'])->get(),
            'species' => Species::query()->pluck('name', 'id'),
            'varieties' => Variety::query()->select(['name', 'id', 'species_id'])->get(),
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlantStoreRequest  $request
     *
     * @return JsonResponse
     */
    public function store(PlantStoreRequest $request): JsonResponse
    {
        $request->store();

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show(plant $plant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function edit(plant $plant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, plant $plant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy(plant $plant)
    {
        //
    }
}
