<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavePropertyUnitBasicRequest;
use App\Http\Resources\PropertyUnitResource;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\PropertyUnitFeature;
use App\Models\PropertyUnitFile;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    public function destroy(Property $property, PropertyUnit $unit)
    {
        // Delete files
        Storage::disk('public_uploads')->deleteDirectory('images/listings/'.$property->slug.'/'.$unit->slug);

        $unit->propertyUnitFeatures()->delete();
        $unit->propertyUnitFiles()->delete();
        $unit->delete();
        return response()->noContent();
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

    public function storeDisclaimer(Property $property, PropertyUnit $unit, Request $request) {
        if (!$request->disclaimer == null) {
            $unit->disclaimer = '';
            $disclaimerRequest = explode(PHP_EOL, $request->disclaimer);
            foreach ($disclaimerRequest as $item) {
                $unit->disclaimer = $unit->disclaimer.' || '.$item;
            }
        } else {
            $unit->disclaimer = null;
        }

        $unit->save();

        $response = [
            'property_unit' => $unit,
            'message' => "Property unit '".$unit->name."' updated successfully.",
        ];
        return response($response, 201);
    }

    public function storeFiles(Request $request, Property $property, PropertyUnit $unit) {
        foreach ($request->file('files') as $file) {
            $filename = time()
                        .'-'.rand(1,9999)
                        .'-'.$unit->slug.'.'
                        .$file->extension();
            // $path = $file->storeAs('images/listings/'.$property->slug, $filename, ['disk' => 'public_uploads']);
            $file->storeAs('images/listings/'.$property->slug.'/'.$unit->slug, $filename, ['disk' => 'public_uploads']);

            $post = new PropertyUnitFile;
            $post->name = $filename;
            $post->type = $this->getFileType($file);
            $post->property_unit_id = $unit->id;
            $post->save();
        }
        $response = [
            'property_unit files' => $unit->propertyUnitFiles,
            'message' => "Property unit '".$unit->name."' updated with new images successfully.",
        ];
        return response($response, 201);
    }

    public function destroyFile(Property $property, PropertyUnit $unit, PropertyUnitFile $file) {
        // Delete file from storage
        Storage::disk('public_uploads')->delete('images/listings/'.$property->slug.'/'.$unit->slug.'/'.$file->name);

        $file->delete();
        return response()->noContent();
    }

    public function updateThumbnail(Property $property, PropertyUnit $unit, Request $request) {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time()
                            .'-'.$unit->slug.'.'
                            .$file->extension();
                $file->storeAs('images/listings/'.$property->slug.'/'.$unit->slug, $filename, ['disk' => 'public_uploads']);
        
                // Delete old thumbnail
                Storage::disk('public_uploads')->delete('images/listings/'.$property->slug.'/'.$unit->slug.'/'.$unit->thumbnail);
                
                $unit->thumbnail = $filename;
                $unit->save();
            }
        }

        $response = [
            'property_unit files' => $unit->propertyUnitFiles,
            'message' => "Property unit '".$unit->name."' updated with new thumbnail successfully.",
        ];
        return response($response, 201);
    }

    public function getFileType($file) {
        $meta = getimagesize($file);
        $file_type = $meta[2];
        
        if(in_array($file_type , array(IMAGETYPE_GIF, IMAGETYPE_JPEG  ,IMAGETYPE_PNG, IMAGETYPE_BMP))) {
            return 'image';
        } return '';
    }
}
