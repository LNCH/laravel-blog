<?php

namespace Lnch\LaravelBlog\Policies;

use Lnch\LaravelBlog\Models\BlogImage;
use Lnch\LaravelBlog\Contracts\BlogImagePolicyInterface;

class BlogImagePolicy extends BasePolicy implements BlogImagePolicyInterface
{
    public function view($user)
    {
        return true;
    }

    public function create($user)
    {
        return true;
    }

    public function edit($user, BlogImage $image)
    {
        return true;
    }

    public function delete($user, BlogImage $image)
    {
        return true;
    }
}
