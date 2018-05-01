<?php


Route::group(['prefix' => config("laravel-blog.route_prefix"), 'middleware' => 'web'], function() {

    if (config("laravel-blog.tags.enabled")) {
        Route::resource("tags", "Lnch\LaravelBlog\Controllers\BlogTagController", ['except' => [
            'create', 'show'
        ]]);
    }

    if (config("laravel-blog.categories.enabled")) {
        Route::resource("categories", "Lnch\LaravelBlog\Controllers\BlogCategoryController", ['except' => [
            'show'
        ]]);
    }

});

