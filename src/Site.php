<?php

namespace Lnch\LaravelBlog;

use Lnch\LaravelBlog\Contracts\SiteInterface;

class Site implements SiteInterface
{
    public static function getSiteId()
    {
        return null;
    }
}