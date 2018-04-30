<?php

namespace Lnch\LaravelBlog;

use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    public function scopeSite($site)
    {
        // Allow results to be filtered by site if applicable
    }

    public function getCurrentSite()
    {
        // Find current site if applicable
    }
}