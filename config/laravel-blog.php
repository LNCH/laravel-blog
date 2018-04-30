<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | By default, routes all routes start with 'blog'. If you want to customise
    | this default routing, change the setting below to match the route prefix
    | you want to use
    |
    */

    'route_prefix' => 'blog',

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    | The path the views can be found at. You should define this as you would
    | when loading a view in a controller. i.e. "admin.blog"
    |
    */

    'views_path' => '',

    /*
    |--------------------------------------------------------------------------
    | Site Model
    |--------------------------------------------------------------------------
    |
    | If you wish to use the blog across multiple 'sites', you will need to
    | define a site model that implements the SiteInterface class provided in
    | the package. You must provide the qualified class name.
    |
    */

    'site_model' => Lnch\LaravelBlog\Site::class,

    'site_primary_key' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Tag Options
    |--------------------------------------------------------------------------
    |
    | All config options related to the blog tags are found in this section.
    |
    */

    'tags' => [

        'enabled'           => true,
        'per_page'          => 15,

    ]

];