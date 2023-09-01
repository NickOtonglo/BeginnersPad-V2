<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavePropertyBasicRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $properties = PropertyResource::collection(Property::where('status', 'published')->latest()->get());
        // return $properties;
        $properties = Property::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%');
            });
        })->where('status', 'published')->latest()->paginate(25);
        return PropertyResource::collection($properties);
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
    public function store(SavePropertyBasicRequest $request)
    {
        $slug = Str::slug($request->name, '-');

        $data = new Property;
        $data->name = $request->name;
        $data->sub_zone_id = $request->sub_zone_id;
        $data->user_id = auth()->user()->id;

        try {
            $data->slug = $slug;
            $data->save();
        } catch (QueryException $e) {
            $data->slug = $slug.'-'.time();
            $data->save();
        }

        $response = [
            'property' => $data,
            'message' => "New property '".$data->name."' created successfully.",
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return new PropertyResource($property);
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
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->name = $request['name'];
        $property->description = $request['description'];
        $property->sub_zone_id = $request['sub_zone']['id'];
        $property->lat = $request['lat'];
        $property->lng = $request['lng'];
        $property->stories = $request['stories'];
        $property->save();

        $response = [
            'property' => $property,
            'message' => "Property '".$property->name."' updated successfully.",
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

    public function getMyListings() {
        $properties = Property::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%');
            });
        })->where('user_id', auth()->user()->id)->latest()->paginate(25);
        return PropertyResource::collection($properties);
    }

    public function showMyListing(Property $property) {
        if ($property->user_id == auth()->user()->id) {
            return new PropertyResource($property);
        } else return response()->noContent();
    }
}
