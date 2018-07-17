<?php

namespace Lnch\LaravelBlog\Policies;

use Lnch\LaravelBlog\Models\BlogPost;
use Lnch\LaravelBlog\Contracts\BlogPostPolicyInterface;

class BlogPostPolicy extends BasePolicy implements BlogPostPolicyInterface
{
    public function view($user)
    {
        return true;
    }

    public function view_draft_post($user, BlogPost $post)
    {
        return true;
    }

    public function create($user)
    {
        return true;
    }

    public function edit($user, BlogPost $post)
    {
        return true;
    }

    public function delete($user, BlogPost $post)
    {
        return true;
    }
}
