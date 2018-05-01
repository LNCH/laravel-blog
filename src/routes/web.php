<?php


Route::group(['prefix' => config("laravel-blog.route_prefix"), 'middleware' => 'web'], function() {

    if (config("laravel-blog.tags.enabled")) {
        Route::resource(config("laravel-blog.tags.taxonomy"), "Lnch\LaravelBlog\Controllers\BlogTagController", ['except' => [
            'create', 'show'
        ]]);
    }

    if (config("laravel-blog.categories.enabled")) {
        Route::resource(config("laravel-blog.categories.taxonomy"), "Lnch\LaravelBlog\Controllers\BlogCategoryController", ['except' => [
            'show'
        ]]);
    }

    if (config("laravel-blog.images.enabled")) {
        Route::resource(config("laravel-blog.images.taxonomy"), "Lnch\LaravelBlog\Controllers\BlogImageController", ['except' => [
            'show'
        ]]);
    }

});

