<?php

namespace Lnch\LaravelBlog\Controllers;

use Illuminate\Http\Request;
use Lnch\LaravelBlog\Models\BlogHelper;
use Lnch\LaravelBlog\Models\BlogPost;
use Lnch\LaravelBlog\Models\Comment;
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

    public function postComment(BlogPost $post, Request $request)
    {
        $this->validate($request, [
            'name' => 'sometimes|string|max:200',
            'email' => 'sometimes|email|max:150',
            'comment' => 'required|string|max:65000',
        ]);

        $post->comments()->create([
            'name' => $request->name,
            'email' => $request->email,
            'user_id' => auth()->id(),
            'body' => $request->comment,
            'status' => config("laravel-blog.comments.requires_approval")
                ? Comment::STATUS_PENDING_APPROVAL : Comment::STATUS_APPROVED,
        ]);

        return redirect(blogUrl("$post->id/$post->slug" . "#post-comments", true));
    }
}
