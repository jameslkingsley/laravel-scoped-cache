<?php

namespace Kingsley\ScopedCache;

class ScopedCacheMacros
{
    /**
     * Performs the cache operation with scoped keys.
     *
     * @return mixed
     */
    public function scopedToModel()
    {
        return function ($model, $arguments) {
            if (empty($arguments)) {
                return new ScopedCacheProxy($model);
            } else {
                return cache(...$this->getScopedArguments($model, $arguments));
            }
        };
    }

    /**
     * Gets the final argument list for the scoped cache call.
     *
     * @return mixed
     */
    public function getScopedArguments()
    {
        return function ($model, $arguments) {
            if (is_array($arguments[0])) {
                foreach ($arguments[0] as $key => $value) {
                    $arguments[0][
                        $this->getScopedCacheKey($model, $key)
                    ] = $value;

                    unset($arguments[0][$key]);
                }
            } else {
                $arguments[0] = $this->getScopedCacheKey($model, $arguments[0]);
            }

            return $arguments;
        };
    }

    /**
     * Gets the model-specific key for the cache item.
     *
     * @return string
     */
    public static function getScopedCacheKey()
    {
        return function ($model, $key) {
            if ($override = $model->getScopedCacheKey($key)) {
                return $override;
            } else {
                $modelName = studly_case(class_basename(get_class($model)));

                return $modelName . '_' . $model->getKey() . ':' . $key;
            }
        };
    }
}
