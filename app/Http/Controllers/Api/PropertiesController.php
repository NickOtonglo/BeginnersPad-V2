<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

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
        })->where('status', 'published')->latest()->paginate(10);
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
    public function store(Request $request)
    {
        //
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
}
