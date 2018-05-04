<?php

namespace Lnch\LaravelBlog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class BlogImage extends BlogModel
{
    use SoftDeletes;

    protected $fillable = [
        'site_id',
        'storage_location',
        'path',
        'caption',
        'alt_text',
    ];

    public $table = "blog_post_images";

    /**
     * Returns the full path to the location the image is stored.
     *
     * @return string
     */
    public function getPath()
    {
        if ($this->storage_location == "storage")
        {
            return public_path("storage/".config("laravel-blog.images.storage_path") . "/" . $this->path);
        }

        return public_path(config("laravel-blog.images.storage_path") . '/' . $this->path);
    }

    /**
     * Returns the URL to display the image.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrl()
    {
        if ($this->storage_location == "storage")
        {
            return url("storage/".config("laravel-blog.images.storage_path") . "/" . $this->path);
        }

        return url(config("laravel-blog.images.storage_path") . "/" . $this->path);
    }
}
