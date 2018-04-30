<?php


Route::group(['prefix' => config("laravel-blog.route_prefix"), 'middleware' => 'web'], function() {

    Route::resource("tags", "Lnch\LaravelBlog\Controllers\BlogTagController", ['except' => [
        'create', 'show'
    ]]);

});

