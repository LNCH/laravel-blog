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

    'site_model' => Lnch\LaravelBlog\Models\Site::class,

    'site_primary_key' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Layout Options
    |--------------------------------------------------------------------------
    |
    | By default Laravel Blog uses a very simple built in layout, that provides
    | simple links to the related blog pages. If you wish to use your own layout,
    | set the layout view below. view_layout will be used in the @extends()
    | directive.
    |
    | By default, the view content will be injected into a section named 'content'.
    | To change this, set the @section() you'd like to use instead in the view_content
    | option below.
    |
    | If you wish to use the default options, either leave these values untouched,
    | or comment them out entirely
    |
    */

    'view_layout' => "laravel-blog::layout",

    'view_content' => 'content',

    /*
    |--------------------------------------------------------------------------
    | Catgeory Options
    |--------------------------------------------------------------------------
    |
    | All config options related to the blog categories are found in this
    | section.
    |
    */

    'categories' => [

        /*
         * Defines whether or not the feature is enabled on the site or not
         */
        'enabled'           => true,

        /*
         * The taxonomy will be used in the routes file to define the route
         */
        'taxonomy'          => 'categories',

        /*
         * How many records should be shown on the index page
         */
        'per_page'          => 10,

    ],

    /*
    |--------------------------------------------------------------------------
    | Tag Options
    |--------------------------------------------------------------------------
    |
    | All config options related to the blog tags are found in this section.
    |
    */

    'tags' => [

        /*
         * Defines whether or not the feature is enabled on the site or not
         */
        'enabled'           => true,

        /*
         * The taxonomy will be used in the routes file to define the route
         */
        'taxonomy'          => 'tags',

        /*
         * How many records should be shown on the index page
         */
        'per_page'          => 15,

    ],

    /*
    |--------------------------------------------------------------------------
    | Image Options
    |--------------------------------------------------------------------------
    |
    | All config options related to the blog images are found in this section.
    |
    */

    'images' => [

        /*
         * Defines whether or not the feature is enabled on the site or not
         */
        'enabled'           => true,

        /*
         * The taxonomy will be used in the routes file to define the route
         */
        'taxonomy'          => 'images',

        /*
         * How many records should be shown on the index page
         */
        'per_page'          => 15,

        /*
         * Where Blog Images will be stored. Relative to the public directory
         */
        'storage_path'      => "images/laravel-blog",

        /*
         * The uploaded file will be stored according to this template, followed
         * by it's original extension.
         *
         * Available tags: [date] [datetime] [filename]
         *                  Ymd    Ymd-His
         */
        'filename_format'   => '[datetime]_[filename]',

    ]

];