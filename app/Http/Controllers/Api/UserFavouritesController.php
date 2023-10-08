<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFavouriteResource;
use App\Models\Article;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\UserFavourite;
use Database\Factories\UserFactory;
use Exception;
use Illuminate\Http\Request;

class UserFavouritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favourites = UserFavourite::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('title', 'like', '%'.request('search_global').'%');
            });
        })->where('user_id', auth()->user()->id)->latest()->paginate(40);
        // $favourites = auth()->user()->userFavourites()->paginate(3);
        return UserFavouriteResource::collection($favourites);
    }

    public function indexWithCategory(string $category)
    {
        $favourites = UserFavourite::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('title', 'like', '%'.request('search_global').'%');
            });
        })->where('user_id', auth()->user()->id)->where('model', $category)->latest()->paginate(40);
        // $favourites = auth()->user()->userFavourites()->paginate(3);
        return UserFavouriteResource::collection($favourites);
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
        $data = new UserFavourite;

        $modelID = '';
        if ($request->model == 'Property') {
            $modelID = Property::where('slug', $request->slug)->first()->id;
            $data->title = $request->name;
        }
        if ($request->model == 'PropertyUnit') {
            $modelID = PropertyUnit::where('slug', $request->slug)->first()->id;
            $data->title = $request->name;
        }
        if ($request->model == 'Article') {
            $modelID = Article::where('slug', $request->slug)->first()->id;
            $data->title = $request->title;
        }
        
        $data->model = $request->model;
        $data->model_id = $modelID;
        $data->user_id = auth()->user()->id;

        try {
            $data->save();
        } catch (Exception $e) {
            // return response()->json([
            //     'message' => "This post already exists in your favourites.",
            //     'errors' => [
            //         'favourite' => [
            //             "The favourite already exists",
            //         ]
            //     ],
            // ], 422);
            $favourite = UserFavourite::where('user_id', auth()->user()->id)->where('model_id', $modelID)->where('model', $request->model)->first();
            return $this->destroy($favourite);
        }

        $response = [
            'user_favourite' => $data,
            'message' => "New favourite added successfully.",
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserFavourite $favourite)
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
    public function destroy(UserFavourite $favourite)
    {
        $favourite->delete();
        return response()->noContent();
    }
}
