<?php

namespace Kingsley\ScopedCache\Tests;

use Kingsley\ScopedCache\Tests\Model;
use Kingsley\ScopedCache\ScopedCacheServiceProvider;

class ScopedCacheTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [ScopedCacheServiceProvider::class];
    }

    /** @test */
    public function can_set_and_get_item_from_cache()
    {
        cache()->flush();

        $model = new Model('Jeff');

        $model->cache(['name' => $model->name], 300);

        $this->assertEquals($model->name, $model->cache('name'));
    }

    /** @test */
    public function assert_items_are_unique_to_model()
    {
        cache()->flush();

        $modelA = new Model('Jeff', 1);
        $modelB = new Model('Not Jeff', 2);

        $modelA->cache(['name' => $modelA->name], 300);
        $modelB->cache(['name' => $modelB->name], 300);

        $this->assertEquals($modelA->name, $modelA->cache('name'));
        $this->assertEquals($modelB->name, $modelB->cache('name'));
    }

    /** @test */
    public function can_access_model_in_remember()
    {
        cache()->flush();

        $model = new Model('Jeff');

        $model->cache()->remember('id', 1, function () {
            return $this->getKey();
        });

        $this->assertEquals($model->getKey(), $model->cache('id'));
    }
}
