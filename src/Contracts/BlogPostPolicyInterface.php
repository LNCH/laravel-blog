<?php

namespace Lnch\LaravelBlog\Contracts;

use Lnch\LaravelBlog\Models\BlogPost;

interface BlogPostPolicyInterface
{
    public function view($user);
    public function create($user);
    public function edit($user, BlogPost $post);
    public function delete($user, BlogPost $post);
}