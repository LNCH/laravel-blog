<?php

namespace Lnch\LaravelBlog;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Lnch\LaravelBlog\Models\BlogCategory;
use Lnch\LaravelBlog\Models\BlogImage;
use Lnch\LaravelBlog\Models\BlogTag;
use Lnch\LaravelBlog\Policies\BlogCategoryPolicy;
use Lnch\LaravelBlog\Policies\BlogTagPolicy;

class LaravelBlogServiceProvider extends ServiceProvider
{
    protected $policies = [
        BlogTag::class              => BlogTagPolicy::class,
        BlogCategory::class         => BlogCategoryPolicy::class,
        BlogImage::class            => BlogImagePolicy::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load package migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load package views
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-blog');

        // Publish config files
        $this->publishes([
            __DIR__.'/../config/laravel-blog.php' => config_path('laravel-blog.php'),
        ], 'laravel-blog/config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/lnch/laravel-blog'),
        ], 'laravel-blog/public');

        // Register policies
        $this->registerPolicies();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Set up the config if not published
        if ($this->app['config']->get('laravel-blog') === null) {
            $this->app['config']->set('laravel-blog', require __DIR__.'/../config/laravel-blog.php');
        }

        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-blog.php',
            'permission'
        );

        // Allow routing to work
        include __DIR__.'/routes/web.php';
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            $policy = Gate::getPolicyFor($key);
            if (!$policy) {
                Gate::policy($key, $value);
            }
        }
    }
}
