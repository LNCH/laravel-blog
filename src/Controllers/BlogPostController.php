<?php

namespace Lnch\LaravelBlog\Controllers;

use Lnch\LaravelBlog\Events\BlogPostCreated;
use Lnch\LaravelBlog\Events\BlogPostDeleted;
use Lnch\LaravelBlog\Events\BlogPostUpdated;
use Lnch\LaravelBlog\Models\BlogPost;
use Lnch\LaravelBlog\Requests\BlogPostRequest;

class BlogPostController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (config("laravel-blog.use_auth_middleware", false)) {
            $this->middleware("auth");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->cannot("view", BlogPost::class)) {
            abort(403);
        }

        $posts = BlogPost::orderBy("is_featured", "desc")
            ->orderBy("published_at", "desc");

        // Separate scheduled if necessary
        if (config("laravel-blog.posts.separate_scheduled", false) === true)
        {
            $posts = $posts->whereRaw("TIMESTAMP(published_at) < NOW()");
        }

        $posts = $posts->paginate(config("laravel-blog.posts.per_page"));

        return view($this->viewPath."posts.index", [
            'posts' => $posts
        ]);
    }

    /**
     * Display a listing of all posts scheduled for the future.
     *
     * @return \Illuminate\Http\Response
     */
    public function scheduled()
    {
        if(auth()->user()->cannot("view", BlogPost::class)) {
            abort(403);
        }

        $posts = BlogPost::whereRaw("TIMESTAMP(published_at) > NOW()")
            ->orderBy("published_at", "asc")
            ->paginate(15);

        return view($this->viewPath."posts.index", [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->cannot("create", BlogPost::class)) {
            abort(403);
        }

        return view($this->viewPath."posts.editor");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogPostRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostRequest $request)
    {
        if(auth()->user()->cannot("create", BlogPost::class)) {
            abort(403);
        }

        $siteId = getBlogSiteID();

        $published_at = $request->published_at
            ? date("Y-m-d H:i:s", strtotime($request->published_at))
            : date("Y-m-d H:i:s", time() - 60);

        $slug = $request->slug
            ? BlogPost::processSlug($request->slug)
            : BlogPost::processSlug($request->title);

        // Create post
        $post = BlogPost::create([
            'site_id' => $siteId,
            'author_id' => auth()->user() ? auth()->user()->id : null,
            'blog_image_id' => $request->blog_image_id,
            'title' => $request->title,
            'slug' =>  $slug,
            'fb_slug' =>  $slug,
            'content' => $request->post_content,
            'status' => $request->status,
            'format' => BlogPost::FORMAT_STANDARD,
            'is_approved' => 1,
            'comments_enabled' => boolval($request->comments_enabled),
            'published_at' => $published_at,
            'is_featured' => boolval($request->get("is_featured", 0))
        ]);

        // Update category
        if($request->category) {
            $post->categories()->sync($request->category);
        }

        // Assign tags
        if($request->tags) {
            $tags = explode(",", $request->tags);
            $post->syncTags($tags);
        }

        // Dispatch the created event
        event(new BlogPostCreated($post));

        // Return
        return redirect($this->routePrefix."posts")
            ->with("success", "Blog post created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param BlogPost $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(BlogPost $post)
    {
        if(auth()->user()->cannot("view", $post)) {
            abort(403);
        }

        return view($this->viewPath."posts.show", [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogPost $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(BlogPost $post)
    {
        if(auth()->user()->cannot("edit", $post)) {
            abort(403);
        }

        return view($this->viewPath."posts.editor", [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param BlogPost                  $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(BlogPostRequest $request, BlogPost $post)
    {
        if(auth()->user()->cannot("edit", $post)) {
            abort(403);
        }

        $oldPost = clone $post;

        $siteId = getBlogSiteID();

        $published_at = $request->published_at
            ? date("Y-m-d H:i:s", strtotime($request->published_at))
            : date("Y-m-d H:i:s", time() - 60);

        $slug = $request->slug
            ? BlogPost::processSlug($request->slug)
            : BlogPost::processSlug($request->title);

        // Create post
        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'fb_slug' => $slug,
            'content' => $request->post_content,
            'status' => $request->status,
            'comments_enabled' => boolval($request->comments_enabled),
            'published_at' => $published_at,
            'blog_image_id' => $request->blog_image_id,
            'is_featured' => boolval($request->is_featured)
        ]);

        // Update category
        if($request->category) {
            $post->categories()->sync($request->category);
        } else {
            // No categories selected
            $post->categories()->detach();
        }

        // Assign tags
        $tags = [];
        if($request->tags) {
            $tags = array_merge($tags, explode(",", $request->tags));
        }
        if($request->tag && count($request->tag)) {
            $tags = array_merge($tags, $request->tag);
        }
        $post->syncTags($tags);

        // Dispatch the updated event
        event(new BlogPostUpdated($oldPost, $post));

        // Return
        return redirect($this->routePrefix."posts/$post->id/edit")
            ->with("success", "Blog post updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogPost $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(BlogPost $post)
    {
        if(auth()->user()->cannot("delete", $post)) {
            abort(403);
        }

        $oldPost = clone $post;

        $post->delete();

        // Dispatch the deleted event
        event(new BlogPostDeleted($oldPost));

        return redirect($this->routePrefix."posts")
            ->with("success", "Blog post deleted successfully");
    }
}
