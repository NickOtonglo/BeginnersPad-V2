<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticlesResource;
use App\Http\Resources\TagsResource;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = '';
        if (!request('sort')) {
            $request = 'DESC';
        } else {
            $request = request('sort');
        }
        // $articles = Article::when(request('search_global'), function($query) {
        //     $query->where(function($q) {
        //         $q->where('slug', 'like', '%'.request('search_global').'%')
        //           ->orWhere('title', 'like', '%'.request('search_global').'%')
        //           ->orWhere('content', 'like', '%'.request('search_global').'%');
        //     });
        // })->latest()->paginate(10);
        $articles = Article::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('title', 'like', '%'.request('search_global').'%')
                  ->orWhere('content', 'like', '%'.request('search_global').'%');
            });
        })->orderBy('created_at', $request)->paginate(10);
        return ArticlesResource::collection($articles);
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
            // $path = $request->file('thumbnail')->storeAs('images/articles/'.$slug, $filename, ['disk' => 'public_uploads']);
            $request->file('thumbnail')->storeAs('images/articles/'.$slug, $filename, ['disk' => 'public_uploads']);

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
    public function show(Article $article)
    {
        return new ArticlesResource($article);
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
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $slug = $article->slug;

        if($request->hasFile('thumbnail')) {
            $filename = time()
                        .'-'.$slug.'.'
                        .$request->thumbnail->extension();
            // $path = $request->file('thumbnail')->storeAs('images/articles/'.$slug, $filename, ['disk' => 'public_uploads']);
            $request->file('thumbnail')->storeAs('images/articles/'.$slug, $filename, ['disk' => 'public_uploads']);

            // Delete old thumbnail
            Storage::disk('public_uploads')->delete('images/articles/'.$slug.'/'.$article->thumbnail);
        }

        $data = $article;
        $data->title = $request->title;
        $data->preview = substr($request->preview, 0, 500);
        $data->content = $request->content;
        if($request->hasFile('thumbnail')) {
            $data->thumbnail = $filename;
        }
        $data->save();

        $this->unlinkTag($article);

        if($request->has('tags')) {
            $tagsRequest = explode(',',$request->tags);
            foreach ($tagsRequest as $tag) {
                $this->createTag($tag);
                $this->linkTagToArticle($data, $tag);
            }
        }

        return new ArticlesResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Delete thumbnail
        Storage::disk('public_uploads')->deleteDirectory('images/articles/'.$article->slug);

        $this->unlinkTag($article);

        $article->delete();
        return response()->noContent();
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
                'name' => $author->username,
                // 'id' => $author->id,
            ],
        ]);
    }

    public function getMyArticles() {
        $request = '';
        if (!request('sort')) {
            $request = 'DESC';
        } else {
            $request = request('sort');
        }
        $articles = Article::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('slug', 'like', '%'.request('search_global').'%')
                  ->orWhere('title', 'like', '%'.request('search_global').'%')
                  ->orWhere('content', 'like', '%'.request('search_global').'%');
            });
        })->where('user_id', auth()->user()->id)->orderBy('created_at', $request)->paginate(10);
        return ArticlesResource::collection($articles);
    }
}
