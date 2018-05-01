<?php

namespace Lnch\LaravelBlog\Contracts;

use Lnch\LaravelBlog\Models\BlogCategory;

interface BlogCategoryPolicyInterface
{
    public function view($user);
    public function create($user);
    public function edit($user, BlogCategory $category);
    public function delete($user, BlogCategory $category);
}