# Laravel Blog
 
This package has been designed for use with installations of **Laravel 5.4 and above.** It may well function perfectly well in previous versions but as of the time of writing these docs, it has not been tested and is not supported.

* [Installation](#installation)
* [Usage](#usage)
    * [Frontend Routes](#frontend-routes)
    * [Backend Routes](#backend-routes)
* [Policies](#policies)
* [Configuration](#configuration)
* [Events](#events)
* [Marking Posts per Site](#marking-posts-per-site)

## Installation

This package can be used in Laravel 5.4 or higher.

In Laravel 5.5 the service provider and facade will automatically get registered. In older versions of the framework just add the service provider and facade in `config/app.php` file:

```php
'providers' => [
    // ...
    Lnch\LaravelBlog\LaravelBlogServiceProvider::class,
];
```

```php
'aliases' => [
    // ...
    Lnch\LaravelBlog\LaravelBlogFacade::class
]
```

Once the package is installed, the database migrations must be run. You can optionally publish the migrations to your database/migrations directory if desired using the command below

```bash
php artisan vendor:publish --tag="laravel-blog/migrations"
```

To create the relevant DB tables for the blog, run the migrations like so:

```bash
php artisan migrate
```

For the blog to function properly, you must also publish the public assets provided. These will be published to the `public/vendor/lnch/laravel-blog` directory. Run the following command to publish the assets:

```bash
php artisan vendor:publish --tag="laravel-blog/public"
```

If you are using the provided layouts then you do not need to reference these public files after publishing them. If you are using a custom layout (explained below in the [config](#config) section), you will have to reference the CSS and JS files like so in your layout:

```html
<link rel="stylesheet" href="{{ asset("vendor/lnch/laravel-blog/css/styles.css") }}" />
```

```html
<script src="{{ asset("vendor/lnch/laravel-blog/js/blog.js") }}"></script>
```

The package also makes use of jQuery so you will also need to reference this before the package JS file if you are using your own layouts.

## Usage

After installation, a set of routes, controllers and views are provided to allow instant use of the package. All controllers referenced are namespaced to `Lnch\LaravelBlog\Controllers` The routes provided are as follows:

### Frontend Routes

| Route                 | Functionality                      | Controller           |
| --------------------- | ---------------------------------- | -------------------- |
| /blog                 | Displays all blog posts (frontend) | BlogController@index |
| /blog/{id}/{slug?}    | Displays an individual post        | BlogController@show  |

### Backend Routes

All backend routes, excluding scheduled posts, are resource routes. Not all HTTP verbs are included with each resource controller. Excluded routes are noted below.

| Route                         | Functionality                              | Controller                   | Excluded Verbs |
| ----------------------------- | ------------------------------------------ | ---------------------------- | -------------- |
| /admin/blog/posts             | Allows management of blog posts            | BlogPostController           |                |
| /admin/blog/posts/scheduled   | Allows management of scheduled blog posts  | BlogPostController@scheduled |                |
| /admin/blog/tags              | Allows management of tags                  | BlogTagController            | create, show   |
| /admin/blog/categories        | Allows management of catgegories           | BlogCategoryController       | show           |
| /admin/blog/images            | Allows management of images                | BlogImageController          | show           |

For more in depth instruction in how to use the various features of the package, please read the documentation pages

## Policies

A number of Policy classes are included, that by default will allow all actions to all users. If you would like to define your own Policy classes for the included models, a set of interfaces are provided to ensure your policies contain all necessary functionality.

Refer to the table below to see which interfaces you should implement for each model

| Model | Interface |
| --- | --- |
| \Lnch\LaravelBlog\Models\BlogPost | \Lnch\LaravelBlog\Contracts\BlogPostPolicyInterface |
| \Lnch\LaravelBlog\Models\BlogTag | \Lnch\LaravelBlog\Contracts\BlogTagPolicyInterface |
| \Lnch\LaravelBlog\Models\BlogCategory | \Lnch\LaravelBlog\Contracts\BlogCategoryPolicyInterface |
| \Lnch\LaravelBlog\Models\BlogImage | \Lnch\LaravelBlog\Contracts\BlogImagePolicyInterface |

## Configuration

To modify the configuration of the package, you can publish the config file with the following command:

```bash
php artisan vendor:publish --tag="laravel-blog/config"
```
This will create a local copy of the configuration file for you to edit. That you can modify to suit your needs. The config
file is commented to assist you in modifying the properties.

## Events

A number of events are provided to allow you to hook your own custom functionality into the Blog process. The events, and their properties are listed below

| Event | Properties |
| --- | --- |
| Lnch\LaravelBlog\Events\BlogPostCreated | $post - The post that was created |
| Lnch\LaravelBlog\Events\BlogPostUpdated | $post - The updated post<br>$oldPost - The post before it was updated |
| Lnch\LaravelBlog\Events\BlogPostDeleted | $post - The post that was deleted |

## Marking posts per Site

If your project has a concept of multiple sites, and you want to restrict posts, tags, categories and images only to 
a certain site, the package is set up for that.

To being with, create a new class that implements `Lnch\LaravelBlog\Contracts\SiteInterface`. This contract only has 
one public static function, with the following signature;

```php
public static function getSiteId();
```

Your model should use this function to define the ID of the Site you wish to link blog posts too at the time. The function
should return either NULL or an integer to define the active site.

Once you have created your model, you will have to update two configuration properties as so:

```php
    // ...
    
    'site_model' => Lnch\LaravelBlog\Models\Site::class,
    
    'site_primary_key' => 'id',
```

Update the `site_model` to the qualified class name of your site class, and if your Site model uses something other than
`id` as it's primary key, change the `site_primary_key` property to represent this.

