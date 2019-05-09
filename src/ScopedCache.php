<?php

namespace Kingsley\ScopedCache;

use Illuminate\Support\Facades\Cache;

trait ScopedCache
{
    /**
     * Cache items specific to the model.
     *
     * @return mixed
     */
    public function cache()
    {
        return Cache::scopedToModel($this, func_get_args());
    }

    /**
     * Gets the model-specific key for the cache item.
     * Leave void to use the default Model_ID:key format.
     *
     * @return string
     */
    public function getModelCacheKey($key)
    {
        //
    }
}
