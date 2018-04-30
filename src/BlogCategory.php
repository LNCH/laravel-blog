<?php

namespace Lnch\LaravelBlog;

use App\Models\SiteModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends SiteModel
{
    use SoftDeletes;

    protected $fillable = ['site_id', 'name', 'description'];

    /**
     * Related post records
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, "blog_post_categories",
            "blog_category_id", "blog_post_id");
    }

    /**
     * Generates and returns the SEO friendly URL for the category archive page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url("blog/category/{$this->id}-") . strtolower(str_replace(" ", "-", $this->name));
    }
}
