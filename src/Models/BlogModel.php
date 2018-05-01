<?php

namespace Lnch\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    protected static function boot()
    {
        parent::boot();

        // Add Site query scope to the models
        static::addGlobalScope('site', function(Builder $builder) {
            $builder->where('site_id', getBlogSiteID());
        });
    }

    public function site()
    {
        if (config("laravel-blog.site_model")) {
            return $this->belongsTo(config("laravel-blog.site_model"),
                config("laravel-blog.site_primary_key"), "site_id");
        }

        return null;
    }
}