<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveArticleRequest;
use App\Http\Resources\TagsResource;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(SaveArticleRequest $request)
    {
        $slug = Str::slug($request->title, '-');

        if ($request->hasFile('thumbnail')) {
            $filename = time()
                        .'-'.$slug.'.'
                        .$request->thumbnail->extension();
            // $path = $request->file('thumbnail')->storeAs('public/images/articles/'.$slug, $filename);
            $path = $request->file('thumbnail')->storeAs('images/articles/'.$slug, $filename, ['disk' => 'public_uploads']);

            $data = new Article;
            $data->title = $request->title;
            $data->preview = substr($request->preview, 0, 500);
            $data->content = $request->content;
            $data->thumbnail = $filename;
            $data->user_id = auth()->user()->id;

            try {
                $data->slug = $slug;
                $data->save();
            } catch (QueryException $e) {
                $data->slug = $slug.'-'.time();
                $data->save();
            }
            
            // TAGS***
            if ($request->has('tags')) {
                $tagsRequest = explode(',', $request->tags);
                foreach ($tagsRequest as $tag) {
                    $this->createTag($tag);
                    $this->linkTagToArticle($data, $tag);
                }
            }

            $response = [
                'article' => $data,
                'message' => "New article '".$data->title."' created successfully.",
            ];
    
            return response($response, 201);
            // return $data;
        } else {
            return response()->json([
                'message' => 'An error occured. Please try again.',
                'errors' => [
                    'thumbnail' => [
                        'Thumbnail missing in request',
                    ]
                ],
            ], 422);
        }
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

    public function createTag($tag) {
        if (!Tag::where('name', $tag)->exists() && $tag !== '') {
            Tag::create([
                'name' => trim($tag),
            ]);
        }
    }

    public function getTags(Article $article) {
        $tags = $article->tags;
        return TagsResource::collection($tags);
    }

    public function linkTagToArticle(Article $article, $tag) {
        $article->tags()->attach(Tag::where('name', $tag)->get());
    }

    public function unlinkTag(Article $article) {
        $article->tags()->detach();
    }

    public function getAuthorName(Article $article) {
        $author = $article->user;
        return response()->json([
            'author' => [
                'name' => $author->name,
                'id' => $author->id,
            ],
        ]);
    }
}
