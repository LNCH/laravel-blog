<?php

namespace Lnch\LaravelBlog\Models;

class BlogHelper
{
    public function initCKEditor()
    {

        $script = "<script src='".config("laravel-blog.posts.ckeditor.path", "")."'></script>
        <script>
            var ckOptions = {
            filebrowserImageBrowseUrl: '". blogUrl('images?embed=true') ."',
                filebrowserImageUploadUrl: '". blogUrl('images/dialog-upload?_token='.csrf_token()) ."'
            }";

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