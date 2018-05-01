<?php

namespace Lnch\LaravelBlog\Models;

use App\Models\SiteModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogImage extends SiteModel
{
    use SoftDeletes;

    const STORAGE_PATH = "app/public/images/blog";

    protected $fillable = [
        'site_id',
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
        return storage_path(self::STORAGE_PATH . '/' . $this->path);
    }

    /**
     * Returns the URL to display the image.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrl()
    {
        return url("/image/original/blog/" . $this->path);
    }
}
