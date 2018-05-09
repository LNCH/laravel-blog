<?php

namespace Lnch\LaravelBlog\Events;

use Illuminate\Queue\SerializesModels;
use Lnch\LaravelBlog\Models\BlogPost;

class BlogPostUpdated
{
    use SerializesModels;

    public $oldPost;
    public $post;

    /**
     * Create a new event instance
     *
     * @param BlogPost $post
     * @retun void
     */
    public function __construct(BlogPost $oldPost, BlogPost $newPost)
    {
        $this->oldPost = $oldPost;
        $this->post = $newPost;
    }
}