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

        return view("laravel-blog::".$this->viewPath."frontend.index", [
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
        // Validate slug & redirect if necessary

        return view("laravel-blog::".$this->viewPath."frontend.show", [
            'post' => $post
        ]);
    }
}
