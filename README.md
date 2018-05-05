* [Installation](#installation)
* [Usage](#usage)

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

After installation, a set of routes, controllers and views are provided to allow instant use of the package. The routes provided are as follows;

### Frontend Routes

| Route                 | Functionality |
| --------------------- | ------------- |
| /blog                 | Displays all blog posts (frontend) |
| /blog/{id}/{slug?}    | Displays all blog posts (frontend) |

### Backend Routes

All backend routes, excluding scheduled posts, are resource routes. Not all HTTP verbs are included with each resource controller. Excluded routes are noted below.

| Route                 | Functionality | Excluded Verbs |
| --------------------- | ------------- | -------------- |
| /admin/blog/posts             | Allows management of blog posts   | |
| /admin/blog/posts/scheduled        | Allows management of scheduled blog posts   | |
| /admin/blog/tags              | Allows management of tags         | create, show |
| /admin/blog/categories        | Allows management of catgegories  | show |
| /admin/blog/images            | Allows management of images       | show |


You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-blog/config"
```

This will create a local copy of the configuration file for you to edit.











-How to install
- Routing
- Basic configuration
- Explain helper functions
- Demonstrate facade
- Explain caching
- Demonstrate Artisan commands
- List events (future)
- How to use the Site functionality
- How to override the policies (interface)
- How to override the controllers
- How to override the views + layouts
- How to override the request classes
