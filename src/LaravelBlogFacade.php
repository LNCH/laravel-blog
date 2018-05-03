<?php

namespace Lnch\LaravelBlog;

use Illuminate\Support\Facades\Facade;

class LaravelBlogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-blog';
    }
}