<?php

namespace Lnch\LaravelBlog\Models;

class BlogHelper
{
    /**
     * Returns a boolean to determine if the current site has any
     * active blog posts to be displayed.
     *
     * @return bool
     */
    public function hasPosts()
    {
        return self::getPublishedPosts()->exists();
    }

    /**
     *
     * @return Builder
     */
    private static function getPublishedPosts() {
        return BlogPost::where('status', BlogPost::STATUS_ACTIVE)
            ->where('site_id', getBlogSiteID())
            ->where('published_at', '<=', date('Y-m-d H:i:s'));
    }

    /**
     * Returns a paginated collection of blog posts.
     *
     * @param $count
     * @return mixed
     */
    public static function posts($count = null)
    {
        if (!$count) {
            $count = config("laravel-blog.frontend.posts_per_page");
        }

        return self::getPublishedPosts()
            ->orderBy("published_at", "desc")
            ->paginate($count);
    }

    /**
     * Retrieves the most recent featured post. If no posts are
     * featured, retrieves the most recent post.
     *
     * @return mixed
     */
    public static function latestFeatured()
    {
        return self::featuredPosts(1)->first();
    }

    /**
     * Retrieves a collection of featured posts. If no posts are
     * featured, retrieves a collection of recent posts.
     *
     * @param int $count
     * @return mixed
     */
    public static function featuredPosts($count = 3)
    {
        $featured = self::getPublishedPosts()
            ->orderBy('is_featured', 'desc')
            ->orderBy("published_at", "desc")
            ->limit($count)
            ->get();

        return $featured;
    }

    /**
     * Retrieves a collection of the most recent posts. Can choose to
     * exclude featured posts from the list also.
     *
     * @param int  $count
     * @param bool $excludeFeatured
     * @return mixed
     */
    public static function recentPosts($count = 3, $excludeFeatured = false)
    {
        $recent = self::getPublishedPosts()
            ->orderBy("published_at", "desc");

        if ($excludeFeatured) {
            $recent = $recent->where("is_featured", false);
        }

        return $recent->limit($count)->get();
    }

    /**
     * Retrieves a list of categories that have at least one post
     * attached to them.
     *
     * @param int $count
     * @return mixed
     */
    public static function categories($count = 5)
    {
        return BlogCategory::whereHas("posts", function($query) {
            $query->where("status", BlogPost::STATUS_ACTIVE)
                ->where('site_id', getBlogSiteID())
                ->where('published_at', '<', date('Y-m-d H:i:s'));
        })
            ->limit($count)
            ->get();
    }

    /**
     * Retrieves a list of tags that have at least one post attached
     * to them.
     *
     * @param int $count
     * @return mixed
     */
    public static function tags($count = 20)
    {
        return BlogTag::whereHas("posts", function($query) {
            $query->where("status", BlogPost::STATUS_ACTIVE)
                ->where('site_id', getBlogSiteID())
                ->where('published_at', '<', date('Y-m-d H:i:s'));
        })
            ->limit($count)
            ->get();
    }

    /**
     * Retrieves a list of posts, sorted by month. Returns the month and year
     *
     * @param int $count
     * @return mixed
     */
    public static function archives($count = 12)
    {
        $archive = self::getPublishedPosts()
            ->orderBy('published_at', 'desc')
            ->groupBy(DB::raw('MONTH(published_at), YEAR(published_at)'))
            ->selectRaw('DATE_FORMAT(published_at, "%Y") as year, DATE_FORMAT(published_at, "%M") as month, DATE_FORMAT(published_at, "%m") as url_month, COUNT(id) as articles')
            ->get();

        return $archive->slice(0, $count);
    }

    /**
     * Returns a collection of posts that are attached to a given category.
     *
     * @param BlogCategory $category
     * @param int          $count
     * @return mixed
     */
    public static function postsByCategory(BlogCategory $category, $count = 15)
    {
        return self::getPublishedPosts()
            ->whereHas("categories", function($query) use($category) {
                $query->where("blog_categories.id", $category->id);
            })
            ->orderBy("published_at", "desc")
            ->paginate($count);
    }

    /**
     * Returns a collection of posts that are attached to a given tag.
     *
     * @param BlogTag $tag
     * @param int     $count
     * @return mixed
     */
    public static function postsByTag(BlogTag $tag, $count = 15)
    {
        return self::getPublishedPosts()
            ->whereHas("tags", function($query) use($tag) {
                $query->where("blog_tags.id", $tag->id);
            })
            ->orderBy("published_at", "desc")
            ->paginate($count);
    }

    /**
     * Returns a collection of posts that were published in a defined year
     * and, optionally, month.
     *
     * @param     $year
     * @param     $month
     * @param int $count
     * @return mixed
     */
    public static function postsByArchive($year, $month, $count = 15)
    {
        $posts = BlogPost::where("status", BlogPost::STATUS_ACTIVE)
            ->where('site_id', getBlogSiteID())
            ->whereRaw("YEAR(published_at) = $year");

        if($month) {
            $posts = $posts->whereRaw("MONTH(published_at) = $month");
        }

        $posts = $posts->orderBy("published_at", "desc")
            ->paginate($count);

        return $posts;
    }

    /**
     * Returns a list of posts written by a given author.
     *
     * @param User $author
     * @param int  $count
     * @return mixed
     */
    public static function postsByAuthor($author, $count = 15)
    {
        return self::getPublishedPosts()
            ->where("author_id", $author->id)
            ->orderBy("published_at", "desc")
            ->paginate($count);
    }

    /**
     * Returns a collection of posts that are scheduled to be published
     * in the future.
     *
     * @param Site|int Either Site object or ID
     * @return mixed
     */
    public static function scheduledPosts()
    {
        $siteId = getBlogSiteID();

        return BlogPost::where("status", BlogPost::STATUS_ACTIVE)
            ->where('site_id', $siteId)
            ->where('published_at', '>', date('Y-m-d H:i:s'))
            ->get();
    }

    public function initCKEditor()
    {
        $script = "<script src='".config("laravel-blog.posts.ckeditor.path", "")."'></script>
        <script>
            var ckOptions = {}";

        if (config("laravel-blog.posts.ckeditor.file_browser_url", null))
        {
            $script .= "
            ckOptions.filebrowserImageBrowseUrl = '". blogUrl(config("laravel-blog.posts.ckeditor.file_browser_url")) ."';";
        }

        if (config("laravel-blog.posts.ckeditor.image_upload_url", null))
        {
            $script .= "
            ckOptions.filebrowserImageUploadUrl = '". blogUrl(config("laravel-blog.posts.ckeditor.image_upload_url") . "?_token=".csrf_token()) ."';";
        }

        if (config("laravel-blog.posts.ckeditor.custom_config", null))
        {
            $script .= "
            ckOptions.customConfig = '". config("laravel-blog.posts.ckeditor.custom_config") ."';";
        }

        $script .= "
            CKEDITOR.replace(\"post_content\", ckOptions);
        </script>";

        echo $script;
    }
}