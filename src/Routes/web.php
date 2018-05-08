<?php

Route::group(['prefix' => config("laravel-blog.frontend_route_prefix"), 'middleware' => 'web'], function() {

    Route::get("/", "Lnch\LaravelBlog\Controllers\BlogController@index");
    Route::get("/{post}/{slug?}", "Lnch\LaravelBlog\Controllers\BlogController@show")->where('post', '[0-9]+');

});


Route::group(['prefix' => config("laravel-blog.route_prefix"), 'middleware' => 'web'], function() {

    Route::get("/", "Lnch\LaravelBlog\Controllers\BlogPostController@index");

    Route::get(config("laravel-blog.posts.taxonomy")."/scheduled",
        "Lnch\LaravelBlog\Controllers\BlogPostController@scheduled");
    Route::resource(config("laravel-blog.posts.taxonomy"),
        "Lnch\LaravelBlog\Controllers\BlogPostController");

    if (config("laravel-blog.tags.enabled")) {
        Route::resource(config("laravel-blog.tags.taxonomy"),
            "Lnch\LaravelBlog\Controllers\BlogTagController",
            [
                'except' => ['create', 'show']
            ]
        );
    }

    if (config("laravel-blog.categories.enabled")) {
        Route::resource(config("laravel-blog.categories.taxonomy"),
            "Lnch\LaravelBlog\Controllers\BlogCategoryController",
            [
                'except' => ['show']
            ]
        );
    }

    if (config("laravel-blog.images.enabled"))
    {
        Route::post(config("laravel-blog.images.taxonomy")."/dialog-upload",
            "Lnch\LaravelBlog\Controllers\BlogImageController@dialogUpload");
        
        Route::resource(config("laravel-blog.images.taxonomy"),
            "Lnch\LaravelBlog\Controllers\BlogImageController",
            [
                'except' => ['show']
            ]
        );
    }

});

