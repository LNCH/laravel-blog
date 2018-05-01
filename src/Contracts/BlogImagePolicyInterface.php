<?php

namespace Lnch\LaravelBlog\Contracts;

use Lnch\LaravelBlog\Models\BlogImage;

interface BlogImagePolicyInterface
{
    public function view($user);
    public function create($user);
    public function edit($user, BlogImage $image);
    public function delete($user, BlogImage $image);
}