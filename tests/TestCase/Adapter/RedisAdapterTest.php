<?php

// Freeman Yam

namespace Pasync\Tests\TestCase\Adapter;

use Pasync\Tests\TestAsset\Adapter\RedisAdapterMock;
use Pasync\Tests\TestAsset\Adapter\RedisClientMock;
use PHPUnit\Framework\TestCase;

class RedisAdapterTest extends TestCase
{
    /** @var RedisAdapterMock */
    protected $adapter;
//
    protected function setup()
    {
        $this->adapter = new RedisAdapterMock();
    }

    /**
     * @group adapter
     */
    public function testAdapterSetGet()
    {
        $expected = 'value' . rand();
        $key = 'key' . rand();
        $this->adapter->set($key, $expected);

        $this->assertSame($expected, $this->adapter->get($key));
    }

    public function testAdapterDel()
    {
        $expected = 'value' . rand();
        $key = 'key' . rand();

        $this->adapter->set($key, $expected);
        $this->assertSame(1, $this->adapter->del($key));
        $this->assertNull($this->adapter->get($key));

        $this->assertSame(0, $this->adapter->del($key . rand()));
    }

    protected function tearDown()
    {
        $this->adapter = null;
    }
}