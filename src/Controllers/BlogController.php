<?php

namespace Lnch\LaravelBlog\Controllers;

use Lnch\LaravelBlog\Models\BlogHelper;
use Lnch\LaravelBlog\Models\BlogPost;
use Lnch\LaravelBlog\Requests\BlogPostRequest;

class BlogController extends Controller
{
    /**
     * Display all blog posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = BlogHelper::posts();

        return view($this->viewPath."frontend.index", [
            'posts' => $posts
        ]);
    }

    /**
     * Show an individual blog post
     *
     * @param BlogPost $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(BlogPost $post, $slug)
    {
        // Add check for draft posts
        $user = auth()->user();
        if($post->status == BlogPost::STATUS_DRAFT && config("laravel-blog.allow_post_previewing", true)) {
            if(!$user || $user->cannot("view_draft_post", $post)) {
                return redirect(config("laravel-blog.frontend_route_prefix"));
            }
        }

        // Check for correct slug, 301 if not
        if($post->slug !== $slug) {
            return redirect(config("laravel-blog.frontend_route_prefix")."/"
                ."$post->id/$post->slug", 301);
        }

        return view($this->viewPath."frontend.show", [
            'post' => $post
        ]);
    }
}
