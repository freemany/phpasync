<?php

// Freeman Yam

namespace Pasync\Tests\TestAsset\Adapter;

use Pasync\Adapter\RedisAdapter;

class RedisAdapterMock extends RedisAdapter
{
    /** @var RedisAdapterMock */
    protected $adapter;

    public function __construct()
    {
        $this->adapter = new RedisClientMock();
    }
}