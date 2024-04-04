<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavePropertyUnitBasicRequest;
use App\Http\Resources\PropertyUnit\PropertyUnitLiteWithPropertyLiteResource;
use App\Http\Resources\PropertyUnitLiteResource;
use App\Http\Resources\PropertyUnitResource;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\PropertyUnitFeature;
use App\Models\PropertyUnitFile;
use App\Models\SubZone;
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
        $data->status = 'active';
        $comment = '';

        try {
            $data->slug = $slug;
            $data->save();
        } catch (QueryException $e) {
            $data->slug = $slug.'-'.time();
            $data->save();
        }

        $response = [
            'property_unit' => $data,
            'model' => 'PropertyUnit',
            'key' => $data->slug,
            'comment' => $comment,
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
        $comment = '';

        $data->save();

        $response = [
            'property_unit' => $data,
            'model' => 'PropertyUnit',
            'key' => $data->slug,
            'comment' => $comment,
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

        $unitName = $unit->name;
        $unitSlug = $unit->slug;
        $unit->propertyUnitFeatures()->delete();
        $unit->propertyUnitFiles()->delete();
        $unit->delete();
        $comment = '';

        $response = [
            'property_unit' => response()->noContent(),
            'model' => 'PropertyUnit',
            'key' => $unitSlug,
            'comment' => $comment,
            'message' => "Property unit '".$unitName."' deleted successfully.",
        ];
        return response($response, 201);
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
        $comment = "Feature(s) '".$request->item."' added";

        // $response = [
        //     'property_unit features' => $featuresRequest,
        //     'message' => "Property unit '".$unit->name."' updated with new features successfully.",
        // ];
        $response = [
            'property_unit' => $unit,
            'model' => 'PropertyUnit',
            'key' => $unit->slug,
            'comment' => $comment,
            'message' => "Property unit '".$unit->name."' updated with new features successfully.",
        ];
        return response($response, 201);
    }

    public function destroyFeature(Property $property, PropertyUnit $unit, PropertyUnitFeature $feature) {
        $feature->delete();
        // return response()->noContent();
        $comment = "Feature '".$feature->item."' deleted";

        $response = [
            'property_unit' => $unit,
            'model' => 'PropertyUnit',
            'key' => $unit->slug,
            'comment' => $comment,
            'message' => "Property unit '".$unit->name."' updated with removed feature successfully.",
        ];
        return response($response, 201);
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
        $comment = 'Disclaimer saved';

        // $response = [
        //     'property_unit' => $unit,
        //     'message' => "Property unit '".$unit->name."' updated successfully.",
        // ];
        $response = [
            'property_unit' => $unit,
            'model' => 'PropertyUnit',
            'key' => $unit->slug,
            'comment' => $comment,
            'message' => "Property unit '".$unit->name."' updated with disclaimer successfully.",
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
        $comment = '';

        // $response = [
        //     'property_unit files' => $unit->propertyUnitFiles,
        //     'message' => "Property unit '".$unit->name."' updated with new thumbnail successfully.",
        // ];
        $response = [
            'property_unit' => $unit,
            'model' => 'PropertyUnit',
            'key' => $unit->slug,
            'comment' => $comment,
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

    public function updateStatus(Property $property, PropertyUnit $unit, Request $request) {
        $request->validate([
            'status' => 'required'
        ]);

        $comment = '';
        $unit->status = $request->status;
        $unit->save();

        $response = [
            'property_unit' => $unit,
            'model' => 'PropertyUnit',
            'key' => $unit->slug,
            'comment' => $comment,
            'message' => "Property unit '".$unit->name."' updated successfully.",
        ];
        return response($response, 201);
    }

    public function sendEnquiry(Property $property, PropertyUnit $unit, Request $request) {
        $sender = auth()->user();
        $receiver = $unit->property->user;

        app(ChatsController::class)->createChatFromListingUnitEnquiry($sender, $receiver, $unit, $request);

        $response = [
            // 'property_unit' => $unit,
            'message' => "Enquiry sent for unit '".$unit->name."' in property '".$unit->property->name."'.",
        ];
        return response($response, 201);
    }

    public function getUnitsQuery() {
        $units = [];
        $request = request()->sort;

        $properties = Property::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%');
            });
        });

        if ($request) {
            if ($request == 'desc' || $request == 'asc') {
                if (auth()->user() && (auth()->user()->role_id <= 3 &&  auth()->user()->role_id >= 1)) {
                    $properties = $properties->orderBy('created_at', $request)->where('status', '!=', 'unpublished')->get();
                    foreach($properties as $property) {
                        foreach($property->propertyUnits as $unit) {
                            if ($unit->status == 'active') {
                                array_push($units, $unit);
                            }
                        }
                    }
                } else {
                    $properties = $properties->orderBy('created_at', $request)->where('status', 'published')->get();
                    foreach($properties as $property) {
                        foreach($property->propertyUnits as $unit) {
                            if ($unit->status == 'active') {
                                array_push($units, $unit);
                            }
                        }
                    }
                }
            }
            if ($request == 'cheap') {}
            if ($request == 'pricey') {}
            if ($request == 'area') {}
            if ($request == 'rooms') {}
        } else {
            $properties = $properties->where('status', 'published')->latest()->get();
            foreach($properties as $property) {
                foreach($property->propertyUnits as $unit) {
                    array_push($units, $unit);
                }
            }
        }

        $filteredUnits = [];
        foreach($units as $unit) {
            if (
                (request('bed') != 0 && $unit->bedrooms != request('bed')) || 
                (request('bath') != 0 && $unit->bathrooms != request('bath')) ||
                (request('area') != 0 && ($unit->floor_area < request('area')-15 || $unit->floor_area > request('area')+15)) || 
                (request('pmin') != 0 && $unit->price < request('pmin')) || 
                (request('pmax') != 0 && $unit->price > request('pmax'))
            ) {
                // dd('xxx');
            } else {
                array_push($filteredUnits, $unit);
            }
        }

        if (count($filteredUnits) > 0) {
            $units = $filteredUnits;
        }
        return PropertyUnitLiteWithPropertyLiteResource::collection(collect($units))->chunk(25);
    }

    public function getUnitsBySubZone(SubZone $subZone) {
        $units = [];
        $request = request()->sort;

        $properties = Property::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%');
            });
        });

        if ($request) {
            if ($request == 'desc' || $request == 'asc') {
                if (auth()->user() && (auth()->user()->role_id <= 3 &&  auth()->user()->role_id >= 1)) {
                    $properties = $properties->orderBy('created_at', $request)->where('status', '!=', 'unpublished')->get();
                    foreach($properties as $property) {
                        foreach($property->propertyUnits as $unit) {
                            if ($unit->status == 'active') {
                                array_push($units, $unit);
                            }
                        }
                    }
                } else {
                    $properties = $properties->orderBy('created_at', $request)->where('status', 'published')->get();
                    foreach($properties as $property) {
                        foreach($property->propertyUnits as $unit) {
                            if ($unit->status == 'active') {
                                array_push($units, $unit);
                            }
                        }
                    }
                }
            }
            if ($request == 'cheap') {}
            if ($request == 'pricey') {}
            if ($request == 'area') {}
            if ($request == 'rooms') {}
        } else {
            if ($subZone) {
                $properties = $properties->where('status', 'published')->where('sub_zone_id', $subZone->id)->latest()->get();
            } else {
                $properties = $properties->where('status', 'published')->latest()->get();
            }
            foreach($properties as $property) {
                foreach($property->propertyUnits as $unit) {
                    array_push($units, $unit);
                }
            }
        }

        $filteredUnits = [];
        foreach($units as $unit) {
            if (
                (request('bed') != 0 && $unit->bedrooms != request('bed')) || 
                (request('bath') != 0 && $unit->bathrooms != request('bath')) ||
                (request('area') != 0 && ($unit->floor_area < request('area')-15 || $unit->floor_area > request('area')+15)) || 
                (request('pmin') != 0 && $unit->price < request('pmin')) || 
                (request('pmax') != 0 && $unit->price > request('pmax'))
            ) {
                // dd('xxx');
            } else {
                array_push($filteredUnits, $unit);
            }
        }

        if (count($filteredUnits) > 0) {
            $units = $filteredUnits;
        }
        
        return PropertyUnitLiteWithPropertyLiteResource::collection(collect($units))->chunk(25);
    }

}