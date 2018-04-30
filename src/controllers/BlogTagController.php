<?php

namespace Lnch\LaravelBlog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lnch\LaravelBlog\BlogTag;

class BlogTagController extends Controller
{
    public function __construct()
    {
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

        $tags = BlogTag::paginate(config("laravel-blog.tags.per-page"));

        return view("laravel-blog::tags.index", ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $this->validate($request, [
            'tags' => 'required|string'
        ]);

        $newTags = explode(",", $request->tags);
        BlogTag::createMany($newTags);

        return redirect("blog/tags")
            ->with("success", (count($newTags) == 1 ? "Tag" : "Tags") . " created successfully");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param BlogTag $tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Request $request, BlogTag $tag)
    {
        if(auth()->user()->cannot("edit", $tag)) {
            abort(403);
        }

        $tags = BlogTag::paginate(10);

        return $this->view("admin.blog.tags.index", [
            'tags' => $tags,
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param BlogTag                   $tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, BlogTag $tag)
    {
        if(auth()->user()->cannot("edit", $tag)) {
            abort(403);
        }

        // Validate
        $this->validate($request, [
            'tag' => 'required|string'
        ]);

        $tag->update([
            'name' => $request->tag
        ]);

        return redirect("admin/blog/tags")
            ->with("success", "Tag updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param BlogTag $tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request, BlogTag $tag)
    {
        if(auth()->user()->cannot("delete", $tag)) {
            abort(403);
        }

        $tag->delete();

        return redirect("admin/blog/tags")
            ->with("success", "Tag deleted successfully");
    }
}
