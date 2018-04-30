<?php

namespace Lnch\LaravelBlog\Contracts;

use Lnch\LaravelBlog\BlogTag;

interface BlogTagPolicyInterface
{
    public function view($user);
    public function create($user);
    public function edit($user, BlogTag $tag);
    public function delete($user, BlogTag $tag);
}