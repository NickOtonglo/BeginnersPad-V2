<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveZoneRequest;
use App\Http\Resources\PropertyPublicResource;
use App\Http\Resources\SubZoneResource;
use App\Http\Resources\Zone\ZoneAdminResource;
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
        // $zones = ZonesResource::collection(Zone::orderBy('name')->get());
        // return $zones;

        $request = request()->sort;

        $zones = Zone::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('id', 'like', '%'.request('search_global').'%')
                  ->orWhere('county_code', 'like', '%'.request('search_global').'%');
            });
        })->withCount('subZones');

        if ($request) {
            if ($request == 'desc' || $request == 'asc') {
                $zones = $zones->orderBy('created_at', $request)->paginate(50);
            }

            // if ($request = 'rating') {
            //     $zones = $zones->orderBy('name')->paginate(15);
            // }
        } else {
            $zones = $zones->orderBy('name')->paginate(50);
        }

        return ZonesResource::collection($zones);
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
        // $zone = Zone::create($request->all());
        $zone = new Zone;
        $zone->name = $request->name;
        $zone->lat = $request->lat;
        $zone->lng = $request->lng;
        $zone->radius = $request->radius*1000;
        $zone->timezone = $request->timezone;
        $zone->description = $request->description;
        $zone->county_code = $request->county_code;
        $zone->save();

        $response = [
            'zone' => $zone,
            'model' => 'Zone',
            'key' => $zone->id,
            'message' => "New zone '".$zone->name."' created successfully.",
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        return new ZoneAdminResource($zone);
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
    public function update(SaveZoneRequest $request, Zone $zone)
    {
        // $zone->update($request->all());

        $zone->name = $request->name;
        $zone->lat = $request->lat;
        $zone->lng = $request->lng;
        $zone->radius = $request->radius*1000;
        $zone->timezone = $request->timezone;
        $zone->description = $request->description;
        $zone->county_code = $request->county_code;
        $zone->save();

        $response = [
            'zone' => $zone,
            'model' => 'Zone',
            'key' => $zone->id,
            'message' => "Zone '".$zone->name."' updated successfully.",
        ];
        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        $zoneId = $zone->id;
        $zoneName = $zone->name;
        $zone->subZones()->delete();
        $zone->delete();

        return response([
            'zone' => response()->noContent(),
            'model' => 'Zone',
            'key' => $zoneId,
            'message' => "Zone '".$zoneName."' deleted successfully.",
        ], 201);
    }

    public function getCountries() {
        $countries = ZoneCountriesResource::collection(ZoneCountry::orderBy('name')->get());
        return $countries;
    }

    public function getCounties() {
        $counties = ZoneCountiesResource::collection(ZoneCounty::orderBy('name', 'ASC')->get());
        return $counties;
    }

    public function getProperties(Zone $zone) {
        $properties = $zone->subZones->properties;
        return PropertyPublicResource::collection($properties);
    }

    public function getZonesByCounty(ZoneCounty $county) {
        $zones = $county->zones;
        return ZonesResource::collection($zones);
    }
}
