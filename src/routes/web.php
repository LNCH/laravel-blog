<?php

Route::group(['prefix' => 'blog', 'middleware' => 'web'], function() {

    Route::resource("tags", "Lnch\LaravelBlog\Controllers\BlogTagController", ['except' => [
        'create', 'show'
    ]]);

});

