<?php

namespace Lnch\LaravelBlog\Events;

use Illuminate\Queue\SerializesModels;
use Lnch\LaravelBlog\Models\BlogPost;

class BlogPostCreated
{
    use SerializesModels;

    public $post;

    /**
     * Create a new event instance
     *
     * @param BlogPost $post
     * @retun void
     */
    public function __construct(BlogPost $post)
    {
        $this->post = $post;
    }
}