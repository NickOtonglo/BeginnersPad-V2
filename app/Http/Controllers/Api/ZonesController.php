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
use App\Models\Property;
use App\Models\PropertyReview;
use App\Models\SubZone;
use App\Models\Zone;
use App\Models\ZoneCountry;
use App\Models\ZoneCounty;
use Illuminate\Http\Request;
use stdClass;

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

    public function getZoneByMostListed() {
        // https://stackoverflow.com/a/44894877/11113076
        $subZoneId = Property::select('sub_zone_id')->groupBy('sub_zone_id')->orderByRaw('COUNT(*) DESC')->first()->sub_zone_id;
        $subZone = SubZone::find($subZoneId);
        // $zone = $subZone->zone;

        // $zone = $subZone->zone;
        // $data = new stdClass();
        // $data->zone = $zone;
        // $data->subZone = $subZone;
        // return $data;

        return $subZone;
    }

    public function getSubZoneByHighestRating() {
        $subZoneGrp = [];
        $subZoneGrpAvg = [];
        $properties = Property::select('sub_zone_id')->groupBy('sub_zone_id')->orderByRaw('COUNT(*) DESC')->get();
        foreach ($properties as $item) {
            $sbzn = SubZone::find($item->sub_zone_id);
            $prpts = $sbzn->properties;
            $propertiesList = [];
            foreach ($prpts as $i) {
                $rating = $i->propertyReviews()->avg('rating');
                array_push($propertiesList, $rating);
            }
            $propertiesList = array_filter($propertiesList);
            $average = 0;
            if (count($propertiesList)) {
                $average = array_sum($propertiesList)/count($propertiesList);
            }
            array_push($subZoneGrpAvg, $average);
            array_push($subZoneGrp, [$sbzn->id]);
        }
        $highestRating = max($subZoneGrpAvg);
        return $highestRating;
    }

    public function getZoneByRating(string $rating = 'all') {
        $zonesList = [];
        $zonesRatingList = [];
        $zonesIdList = [];
        $ratingsList = [];
        $zones = Zone::get();
        foreach ($zones as $zone) {
            $ratingZone = [];
            $avRatingZone = 0;
            foreach ($zone->properties as $property) {
                $ratingProperty = [];
                $avRatingProperty = 0;
                foreach ($property->propertyReviews as $review) {
                    array_push($ratingProperty, $review->rating);
                    array_push($ratingsList, [$property->name, $review->rating]);
                }
                if (count($ratingProperty)) {
                    $avRatingProperty = array_sum($ratingProperty)/count($ratingProperty);
                }
                array_push($ratingZone, $avRatingProperty);
            }
            if (count($ratingZone)) {
                $avRatingZone = array_sum($ratingZone)/count($ratingZone);
            }
            if ($avRatingZone > 0) {
                array_push($zonesRatingList, $avRatingZone);
                // array_push($zonesIdList, $avRatingZone);
                array_push($zonesList, [$zone->id, $zone->name, number_format($avRatingZone, 1, '.', '')]);
            }
        }
        
        if ($rating == 'all') {
            return $zonesList;
        } else if ($rating == 'highest') {
            $zoneRatingIndex = array_search(max($zonesRatingList), $zonesRatingList);
            return $zonesList[$zoneRatingIndex];
        } else if ($rating == 'lowest') {
            $zoneRatingIndex = array_search(min($zonesRatingList), $zonesRatingList);
            return $zonesList[$zoneRatingIndex];
        }
    }

    // to be continued...
    public function sortZoneRatingsDesc($mainList) {
        $oldlist = $mainList;
        $newList = [];
        for ($i = 0; $i <= count($mainList); $i++) {
            for ($j = 0; $j <= count($mainList[$i]); $j++) {

            }
        }
    }

    public function getZoneAverageRent(Zone $zone) {
        $avgList = [];
        $properties = $zone->properties()->where('status', 'published')->get();
        foreach ($properties as $property) {
            $unitsAvg = $property->propertyUnits()->where('status', 'active')->avg('price');
            array_push($avgList, $unitsAvg);
        }
        $average = array_sum($avgList)/count($avgList);
        return (float) $average;
    }

    public function getZoneByRent(string $rent = 'all') {
        $zonesList = [];
        $zonesRentList = [];
        $zonesIdList = [];
        $rentList = [];
        $zones = Zone::get();
        foreach ($zones as $zone) {
            $rentZone = [];
            $avRentZone = 0;
            foreach ($zone->properties as $property) {
                $rentProperty = [];
                $avRentProperty = 0;
                foreach ($property->propertyUnits as $unit) {
                    array_push($rentProperty, $unit->price);
                    array_push($rentList, [$property->name, $unit->name, $unit->price]);
                }
                if (count($rentProperty)) {
                    $avRentProperty = array_sum($rentProperty)/count($rentProperty);
                }
                array_push($rentZone, $avRentProperty);
            }
            if (count($rentZone)) {
                $avRentZone = array_sum($rentZone)/count($rentZone);
            }
            if ($avRentZone > 0) {
                array_push($zonesRentList, $avRentZone);
                // array_push($zonesIdList, $avRentZone);
                array_push($zonesList, [$zone->id, $zone->name, $avRentZone]);
            }
        }
        
        if ($rent == 'all') {
            return $zonesList;
        } else if ($rent == 'highest') {
            $zoneRentIndex = array_search(max($zonesRentList), $zonesRentList);
            return $zonesList[$zoneRentIndex];
        } else if ($rent == 'lowest') {
            $zoneRentIndex = array_search(min($zonesRentList), $zonesRentList);
            return $zonesList[$zoneRentIndex];
        }
    }
}
