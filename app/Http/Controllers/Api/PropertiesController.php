<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavePropertyBasicRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Models\PropertyFeature;
use App\Models\PropertyFile;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $property->sub_zone_id = $request['sub_zone_id'];
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

    public function storeFeatures(Property $property, Request $request) {
        $request->validate([
            'item' => 'required',
        ]);

        $featuresRequest = explode(PHP_EOL, $request->item);
        foreach ($featuresRequest as $item) {
            $feature = new PropertyFeature;
            $feature->item = trim($item);
            $feature->property_id = $property->id;
            $feature->save();
        }

        $response = [
            'property features' => $featuresRequest,
            'message' => "Property '".$property->name."' updated with new features successfully.",
        ];
        return response($response, 201);
    }

    public function destroyFeature(Property $property, PropertyFeature $feature) {
        $feature->delete();
        return response()->noContent();
    }

    public function storeFiles(Request $request, Property $property) {
        foreach ($request->file('files') as $file) {
            $filename = time()
                        .'-'.rand(1,9999)
                        .'-'.$property->slug.'.'
                        .$file->extension();
            // $path = $file->storeAs('images/listings/'.$property->slug, $filename, ['disk' => 'public_uploads']);
            $file->storeAs('images/listings/'.$property->slug, $filename, ['disk' => 'public_uploads']);

            $post = new PropertyFile;
            $post->name = $filename;
            $post->type = $this->getFileType($file);
            $post->property_id = $property->id;
            $post->save();
        }
        $response = [
            'property files' => $property->propertyFiles,
            'message' => "Property '".$property->name."' updated with new images successfully.",
        ];
        return response($response, 201);
    }

    public function destroyFile(Property $property, PropertyFile $file) {
        // Delete file from storage
        Storage::disk('public_uploads')->delete('images/listings/'.$property->slug.'/'.$file->name);

        $file->delete();
        return response()->noContent();
    }

    public function updateThumbnail(Property $property, Request $request) {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time()
                            .'-'.$property->slug.'.'
                            .$file->extension();
                $file->storeAs('images/listings/'.$property->slug, $filename, ['disk' => 'public_uploads']);
        
                // Delete old thumbnail
                Storage::disk('public_uploads')->delete('images/listings/'.$property->slug.'/'.$property->thumbnail);
                
                $property->thumbnail = $filename;
                $property->save();
            }
        }

        $response = [
            'property thumbnail' => $property,
            'message' => "Property '".$property->name."' updated with new thumbnail successfully.",
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

    public function indexHome()
    {
        $properties = Property::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%');
            });
        })->where('status', 'published')->latest()->paginate(9);
        return PropertyResource::collection($properties);
    }
}
