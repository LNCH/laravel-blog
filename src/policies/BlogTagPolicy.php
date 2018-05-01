<?php

namespace Lnch\LaravelBlog\Policies;

use Lnch\LaravelBlog\Models\BlogTag;
use Lnch\LaravelBlog\Contracts\BlogTagPolicyInterface;

class BlogTagPolicy extends BasePolicy implements BlogTagPolicyInterface
{
    public function view($user)
    {
        return true;
    }

    public function create($user)
    {
        return true;
    }

    public function edit($user, BlogTag $tag)
    {
        return true;
    }

    public function delete($user, BlogTag $tag)
    {
        return true;
    }
}
