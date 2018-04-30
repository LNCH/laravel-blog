<?php

namespace Lnch\LaravelBlog;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    protected static function boot()
    {
        parent::boot();

        // Get site Model
        $siteClass = config("laravel-blog.site_model");

        if ($siteClass) {
            $siteClassInstance = new $siteClass();

            // Get site ID
            $siteId = $siteClassInstance::getSiteId();

            static::addGlobalScope('site', function(Builder $builder) use($siteId) {
                $builder->where('site_id', $siteId);
            });
        }
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