<?php

namespace Kingsley\ScopedCache;

use Closure;

class ScopedCacheProxy
{
    /**
     * Model the cache is scoped to.
     *
     * @var mixed
     */
    protected $model;

    /**
     * Constructor method.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Handle the incoming method call.
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $arguments[0] = ScopedCacheMacros::getScopedCacheKey()($this->model, $arguments[0]);

        foreach ($arguments as $key => &$value) {
            if ($value instanceof Closure) {
                $arguments[$key] = $value->bindTo($this->model);
            }
        }

        return cache()->$method(...$arguments);
    }
}
