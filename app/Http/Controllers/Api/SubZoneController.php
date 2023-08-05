<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveSubZoneRequest;
use App\Http\Resources\SubZoneNatureResource;
use App\Http\Resources\SubZoneResource;
use App\Models\SubZone;
use App\Models\SubZoneNature;
use App\Models\Zone;
use Illuminate\Http\Request;

class SubZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subZones = SubZoneResource::collection(SubZone::orderBy('name')->get());
        return $subZones;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Zone $zone, SaveSubZoneRequest $request)
    {
        $subZone = new SubZone();
        $subZone->name = $request->name;
        $subZone->lat = $request->lat;
        $subZone->lng = $request->lng;
        $subZone->radius = $request->radius*1000;
        $subZone->description = $request->description;
        $subZone->nature_id = $request->nature_id;
        $subZone->zone_id = $zone->id;
        $subZone->save();

        $response = [
            'sub-zone' => $subZone,
            'message' => "New zone '".$subZone->name."' created successfully.",
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getNatures() {
        $natures = SubZoneNatureResource::collection(SubZoneNature::get());
        return $natures;
    }
}
