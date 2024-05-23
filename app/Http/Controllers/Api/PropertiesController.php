<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavePropertyBasicRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\Property\PropertyLogResource;
use App\Http\Resources\PropertyLiteResource;
use App\Http\Resources\PropertyPublicResource;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Models\PropertyFeature;
use App\Models\PropertyFile;
use App\Models\PropertyLog;
use App\Models\SubZone;
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
                    $properties = $properties->orderBy('created_at', $request)->where('status', '!=', 'unpublished')->paginate(25);
                } else {
                    $properties = $properties->orderBy('created_at', $request)->where('status', 'published')->paginate(25);
                }
            }
            if ($request == 'cheap') {}
            if ($request == 'pricey') {}
            if ($request == 'area') {}
            if ($request == 'rooms') {}
        } else {
            $properties = $properties->where('status', 'published')->latest()->paginate(25);
        }
        return PropertyLiteResource::collection($properties);
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

        $comment = '';
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
            'model' => 'Property',
            'key' => $data->slug,
            'comment' => $comment,
            'message' => "New property '".$data->name."' created successfully.",
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        // if (
        //     $property->status == 'published'
        //  || auth()->user()->id == $property->user_id
        //  || auth()->user()->role_id == 3
        //  || auth()->user()->role_id == 2
        //  || auth()->user()->role_id == 1
        //  ) {
        //      return new PropertyPublicResource($property);
        // } else {
        //     abort(404);
        // }

        if (
            ($property->status == 'published') || 
            (auth()->user()->id == $property->user_id) || 
            (($property->status != 'unpublished' && $property->status != 'private') && 
                (auth()->user()->role_id == 3 || 
                 auth()->user()->role_id == 2 || 
                 auth()->user()->role_id == 1)
            )
         ) {
             return new PropertyPublicResource($property);
        } else {
            abort(404);
        }
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
        $comment = '';
        $property->name = $request['name'];
        $property->description = $request['description'];
        $property->sub_zone_id = $request['sub_zone_id'];
        $property->lat = $request['lat'];
        $property->lng = $request['lng'];
        $property->stories = $request['stories'];
        $property->save();

        $response = [
            'property' => $property,
            'model' => 'Property',
            'key' => $property->slug,
            'comment' => $comment,
            'message' => "Property '".$property->name."' updated successfully.",
        ];
        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        foreach($property->propertyUnits as $unit) {
            app(PropertyUnitsController::class)->destroy($property, $unit);
        }
        $comment = '';
        $propertySlug = $property->slug;
        $propertyName = $property->name;
        $property->propertyReviews()->delete();
        $property->propertyFeatures()->delete();
        $property->propertyFiles()->delete();
        Storage::disk('public_uploads')->deleteDirectory('images/listings/'.$property->slug);
        $property->delete();

        $response = [
            'property' => response()->noContent(),
            'model' => 'Property',
            'key' => $propertySlug,
            'comment' => $comment,
            'message' => "Property '".$propertyName."' deleted successfully.",
        ];
        return response($response, 201);
    }

    public function getMyListings() {
        $request = request()->sort;

        $properties = Property::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%');
            });
        })->where('user_id', auth()->user()->id);

        if ($request && ($request == 'desc' || $request == 'asc')) {
            $properties = $properties->orderBy('created_at', $request)->paginate(25);
        } else {
            $properties = $properties->latest()->paginate(25);
        }

        return PropertyResource::collection($properties);
    }

    public function getMyListingsByStatus(string $status) {
        $request = request()->sort;

        $properties = Property::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%');
            });
        });

        $properties = $properties->where('user_id', auth()->user()->id);

        if ($status !== 'all') {
            $properties = $properties->where('status', $status);
        }

        if ($request && ($request == 'desc' || $request == 'asc')) {
            $properties = $properties->orderBy('created_at', $request)->paginate(25);
        } else {
            $properties = $properties->latest()->paginate(25);
        }

        return PropertyLiteResource::collection($properties);
    }

    public function getMyListingsBySubZone(SubZone $subZone) {
        $properties = $subZone->properties()->where('user_id', auth()->user()->id)->paginate(25);
        return PropertyLiteResource::collection($properties);
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

    public function destroyFile(Property $property, $filename) {
        // Delete file from storage
        $file = PropertyFile::where('name', $filename)->first();
        Storage::disk('public_uploads')->delete('images/listings/'.$property->slug.'/'.$file->name);

        $file->delete();
        return response()->noContent();
    }

    public function updateThumbnail(Property $property, Request $request) {
        $comment = '';
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
            'property' => $property,
            'model' => 'Property',
            'key' => $property->slug,
            'comment' => $comment,
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
        return PropertyLiteResource::collection($properties);
    }

    public function getPropertiesByStatus(string $status) {
        $request = request()->sort;

        $properties = Property::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%');
            });
        });

        if ($status == 'all') {
            $properties = $properties->where('status', '!=', 'unpublished');
        } else {
            $properties = $properties->where('status', $status);
        }

        if ($request && ($request == 'desc' || $request == 'asc')) {
            $properties = $properties->orderBy('created_at', $request)->paginate(25);
        } else {
            $properties = $properties->latest()->paginate(25);
        }

        return PropertyLiteResource::collection($properties);
    }

    public function getPropertiesBySubZone(SubZone $subZone) {
        $properties = '';
        if (auth()->user() && (auth()->user()->role_id <= 3 &&  auth()->user()->role_id >= 1)) {
            $properties = $subZone->properties()->where('status', '!=' ,'unpublished')->paginate(25);
        } else {
            $properties = $subZone->properties()->where('status', 'published')->paginate(25);
        }
        return PropertyLiteResource::collection($properties);
    }

    public function updateStatus(Property $property, Request $request) {
        $request->validate([
            'status' => 'required'
        ]);

        $comment = '';
        $property->status = $request->status;
        $property->save();
        if ($request->status == 'unpublished') {}

        if ($request->status == 'pending') {}

        if ($request->status == 'published') {}

        if ($request->status == 'rejected') {
            $comment = $request->comment;
        }
        
        if ($request->status == 'suspended') {
            $comment = $request->comment;
        }

        if ($request->status == 'private') {}

        $response = [
            'property' => $property,
            'model' => 'Property',
            'key' => $property->slug,
            'message' => "Property '".$property->name."' updated successfully.",
            'comment' => $comment,
        ];
        return response($response, 201);
    }

    public function getLogs(Property $property) {
        $logs = PropertyLog::where('slug', $property->slug)->latest()->get();
        return PropertyLogResource::collection($logs);
    }

    public function getAllLogs() {
        $request = request()->sort;

        $logs = PropertyLog::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('name', 'like', '%'.request('search_global').'%')
                  ->orWhere('status', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%')
                  ->orWhere('comment', 'like', '%'.request('search_global').'%');
            });
        });

        if ($request) {
            if ($request == 'desc' || $request == 'asc') {
                $logs = $logs->orderBy('created_at', $request);
            }
        }
        return PropertyLogResource::collection($logs->paginate(50));
    }

    public function sendEnquiry(Property $property, Request $request) {
        $sender = auth()->user();
        $receiver = $property->user;

        app(ChatsController::class)->createChatFromListingEnquiry($sender, $receiver, $property, $request);

        $response = [
            // 'property' => $property,
            'message' => "Enquiry sent for property '".$property->name."'.",
        ];
        return response($response, 201);
    }
}
