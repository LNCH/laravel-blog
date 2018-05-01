<?php

namespace Lnch\LaravelBlog\Policies;

use Lnch\LaravelBlog\Models\BlogCategory;
use Lnch\LaravelBlog\Contracts\BlogCategoryPolicyInterface;

class BlogCategoryPolicy extends BasePolicy implements BlogCategoryPolicyInterface
{
    public function view($user)
    {
        return true;
    }

    public function create($user)
    {
        return true;
    }

    public function edit($user, BlogCategory $category)
    {
        return true;
    }

    public function delete($user, BlogCategory $category)
    {
        return true;
    }
}
