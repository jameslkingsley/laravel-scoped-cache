# Model specific cache items made easy

This package adds a trait that provides a `cache` method for interacting with your app's cache, but scoped to your Eloquent models. This removes the need to constantly append the model ID to your cache keys. Just access your cache like this instead `$user->cache('Avatar')`.

Under the hood it will prefix your cache keys with a generated model-specific key, in the format `Model_ID:your-key`. You can completely override this format by implementing the `getModelCacheKey` method on your model.

## Installation

You can install the package via composer:

```bash
composer require jameslkingsley/laravel-scoped-cache
```

## Usage

Import the trait and use it on any Eloquent model. You can also use it on non-eloquent classes, providing they have a `getKey` method that returns their unique reference.

```php
use Kingsley\ScopedCache\ScopedCache;

class User extends Model
{
    use ScopedCache;
}
```

Now you can use the cache how you would normally. You can set/get items directly from the `cache` method, or call any other cache method by leaving the argument list empty.

```php
$user->cache(['name', $user->name], 5);
$user->cache('name', 'default name');

$user->cache()->remember('name', 5, function () {
    // $this refers to the model this cache instance is scoped to
    return $this->name;
});
```

Keep in mind that this package is expecting the first argument of proxied calls to the cache to be the cache key. There might be some cases where custom macro's break this format.
