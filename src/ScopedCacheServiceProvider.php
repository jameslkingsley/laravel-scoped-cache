<?php

namespace Kingsley\ScopedCache;

use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;

class ScopedCacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Repository::mixin(new ScopedCacheMacros);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
