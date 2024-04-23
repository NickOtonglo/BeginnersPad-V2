<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveTagRequest;
use App\Http\Resources\ArticlesResource;
use App\Http\Resources\TagsResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('name', 'ASC')->get();
        return TagsResource::collection($tags);
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
    public function store(SaveTagRequest $request)
    {
        $tagsRequest = explode(',', $request->name);
        $tags = [];

        foreach ($tagsRequest as $item) {
            $tag = Str::slug(trim($item), '-');
            array_push($tags, trim($item));

            if (!Tag::where('name', $tag)->exists()) {
                Tag::create([
                    'name' => $tag,
                ]);
            } else {
                return response()->json([
                    'message' => "Tag '".$tag."' already exists. Operation aborted!",
                    'errors' => [
                        'name' => [
                            "The tag '".$tag."' already exists",
                        ]
                    ],
                ], 422);
            }
        }

        $response = [
            'tags' => $tags,
            // 'message' => "New tag(s) ".$tags." added successfully.",
            'message' => "New tag(s) added successfully.",
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return new TagsResource($tag);
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
    public function update(SaveTagRequest $request, $id)
    {
        $tagNew = Tag::where('id', $request->id)->first();
        $tagNew->name = Str::slug(trim($request->name), '-');

        if(!Tag::where('name',$request->name)->exists()) {
            $tagNew->save();
        }
        return new TagsResource($tagNew);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->articles()->detach();
        $tag->delete();
        return response()->noContent();
    }

    public function getArticles(Tag $tag) {
        $articles = $tag->articles()->when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('title', 'like', '%'.request('search_global').'%')
                  ->orWhere('content', 'like', '%'.request('search_global').'%');
            });
        })->latest()->paginate(10);
        return ArticlesResource::collection($articles);
        
        // $articles = $tag->articles;
        // if ($articles) {
        //     return ArticlesResource::collection($articles);
        // }
        // return response()->noContent();
    }
}
