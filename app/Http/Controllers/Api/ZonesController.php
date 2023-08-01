<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveZoneRequest;
use App\Http\Resources\ZoneCountiesResource;
use App\Http\Resources\ZoneCountriesResource;
use App\Http\Resources\ZonesResource;
use App\Models\Zone;
use App\Models\ZoneCountry;
use App\Models\ZoneCounty;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = ZonesResource::collection(Zone::orderBy('name')->get());
        return $zones;
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
    public function store(SaveZoneRequest $request)
    {
        $zone = Zone::create($request->all());
        $response = [
            'zone' => $zone,
            'message' => "New article '".$zone->name."' created successfully.",
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

    public function getCountries() {
        $countries = ZoneCountriesResource::collection(ZoneCountry::orderBy('name')->get());
        return $countries;
    }

    public function getCounties() {
        $counties = ZoneCountiesResource::collection(ZoneCounty::orderBy('code')->get());
        return $counties;
    }
}
