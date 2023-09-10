<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavePropertyUnitBasicRequest;
use App\Http\Resources\PropertyUnitResource;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\PropertyUnitFeature;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Property $property)
    {
        $units = $property->propertyUnits()->paginate(5);
        return PropertyUnitResource::collection($units);
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
    public function store(Property $property, SavePropertyUnitBasicRequest $request)
    {
        $slug = Str::slug($request->name, '-');

        $data = new PropertyUnit;
        $data->name = $request->name;
        $data->story = $request->story;
        $data->price = $request->price;
        $data->init_deposit = $request->init_deposit;
        $data->init_deposit_period = $request->init_deposit_period;
        $data->floor_area = $request->floor_area;
        $data->bathrooms = $request->bathrooms;
        $data->bedrooms = $request->bedrooms;
        $data->property_id = $property->id;

        try {
            $data->slug = $slug;
            $data->save();
        } catch (QueryException $e) {
            $data->slug = $slug.'-'.time();
            $data->save();
        }

        $response = [
            'property_unit' => $data,
            'message' => "New property unit '".$data->name."' created successfully.",
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property, PropertyUnit $unit)
    {
        return new PropertyUnitResource($unit);

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
    public function update(Property $property, PropertyUnit $unit, SavePropertyUnitBasicRequest $request)
    {
        $data = $unit;
        $data->name = $request->name;
        $data->story = $request->story;
        $data->price = $request->price;
        $data->init_deposit = $request->init_deposit;
        $data->init_deposit_period = $request->init_deposit_period;
        $data->floor_area = $request->floor_area;
        $data->bathrooms = $request->bathrooms;
        $data->bedrooms = $request->bedrooms;
        $data->property_id = $property->id;

        $data->save();

        $response = [
            'property_unit' => $data,
            'message' => "Property unit '".$data->name."' updated successfully.",
        ];

        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeFeatures(Property $property, PropertyUnit $unit, Request $request) {
        $request->validate([
            'item' => 'required',
        ]);

        $featuresRequest = explode(PHP_EOL, $request->item);
        foreach ($featuresRequest as $item) {
            $feature = new PropertyUnitFeature;
            $feature->item = trim($item);
            $feature->property_unit_id = $unit->id;
            $feature->save();
        }

        $response = [
            'property_unit features' => $featuresRequest,
            'message' => "Property unit '".$unit->name."' updated with new features successfully.",
        ];
        return response($response, 201);
    }

    public function destroyFeature(Property $property, PropertyUnit $unit, PropertyUnitFeature $feature) {
        $feature->delete();
        return response()->noContent();
    }
}
