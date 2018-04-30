<?php

namespace Lnch\LaravelBlog\Controllers;

use Lnch\LaravelBlog\BlogTag;
use Lnch\LaravelBlog\Requests\BlogTagRequest;

class BlogTagController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!config("laravel-blog.tags.enabled")) {
            abort(404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->cannot("view", BlogTag::class)) {
            abort(403);
        }

        $tags = BlogTag::paginate(config("laravel-blog.tags.per_page"));

        return view("laravel-blog::".$this->viewPath."tags.index", [
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Lnch\LaravelBlog\Requests\BlogTagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogTagRequest $request)
    {
        if(auth()->user()->cannot("create", BlogTag::class)) {
            abort(403);
        }

        $newTags = explode(",", $request->tags);
        BlogTag::createMany($newTags);

        return redirect($this->routePrefix."tags")
            ->with("success", (count($newTags) == 1 ? "Tag" : "Tags") . " created successfully");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogTag $tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(BlogTag $tag)
    {
        if(auth()->user()->cannot("edit", $tag)) {
            abort(403);
        }

        $tags = BlogTag::paginate(config("laravel-blog.tags.per_page"));

        return view("laravel-blog::".$this->viewPath."tags.index", [
            'tags' => $tags,
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Lnch\LaravelBlog\Requests\BlogTagRequest $request
     * @param BlogTag                                   $tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(BlogTagRequest $request, BlogTag $tag)
    {
        if(auth()->user()->cannot("edit", $tag)) {
            abort(403);
        }

        $tag->update(['name' => $request->tag]);

        return redirect($this->routePrefix."tags")
            ->with("success", "Tag updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Lnch\LaravelBlog\Requests\BlogTagRequest $request
     * @param BlogTag                                   $tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(BlogTagRequest $request, BlogTag $tag)
    {
        if(auth()->user()->cannot("delete", $tag)) {
            abort(403);
        }

        $tag->delete();

        return redirect($this->routePrefix."tags")
            ->with("success", "Tag deleted successfully");
    }
}
