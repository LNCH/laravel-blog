<?php

namespace Lnch\LaravelBlog\Models;

class BlogHelper
{
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