<?php

namespace Kingsley\ScopedCache\Tests;

use Kingsley\ScopedCache\ScopedCache;

class Model
{
    use ScopedCache;

    public $id;
    public $name;

    public function __construct($name, $id = 1)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getKey()
    {
        return $this->id;
    }
}
