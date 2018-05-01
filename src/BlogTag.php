<?php

namespace Lnch\LaravelBlog;

use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTag extends BlogModel
{
    use SoftDeletes;

    protected $fillable = [
        'site_id',
        'name'
    ];

    /**
     * Related post records
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, "blog_post_tags",
            "blog_tag_id", "blog_post_id");
    }

    /**
     * Creates a number of tag records from an array of tag names,
     * ignoring any duplicate tags.
     *
     * @param $tags
     * @return array
     */
    public static function createMany($tags)
    {
        $ids = [];

        foreach($tags as $tag)
        {
            // Capitalise the words
            $name = ucwords(strtolower(trim($tag)));
            $tag = self::where("name", $name)->first();

            $siteId = null;
            $siteClass = config("laravel-blog.site_model");
            if ($siteClass) {
                $siteClassInstance = new $siteClass();
                $siteId = $siteClassInstance::getSiteId();
            }

            // If the tag doesn't exist, create it
            if(!$tag) {
                $tag = self::create([
                    'site_id' => $siteId,
                    'name' => $name
                ]);
            }

            // Add to list
            $ids[] = $tag->id;
        }

        return $ids;
    }

    /**
     * Generates and returns the SEO friendly URL for the tag archive page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        $name = str_replace(" ", "-", str_replace("#", "", $this->name));
        return url("blog/tag/{$this->id}-") . strtolower($name);
    }
}
