<?php
// Freeman Yam

namespace Pasync\Adapter;

use RedisClient\RedisClient;

class RedisAdapter implements AdapterInterface
{
    /**
     * @var \RedisClient\RedisClient
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $config = [
        'server' => 'tcp://127.0.0.1:6399', // or 'unix:///tmp/redis.sock'
        'timeout' => 2,
    ];

    /**
     * @var array
     */
    protected $resTpl = [
        'done' => null,
        'error' => null,
        'response' => null,
    ];

    /**
     * RedisAdapter constructor.
     */
    public function __construct()
    {
        $this->adapter = new RedisClient($this->config);
    }

    /**
     * @param string $key
     *
     * @return null|string
     */
    public function get(string $key): ?string
    {
        return $this->adapter->get($key);
    }

    /**
     * @param string $key
     *
     * @return int
     */
    public function del(string $key): int
    {
        return $this->adapter->del($key);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool|null
     */
    public function set(string $key, string $value): ?bool
    {
        return $this->adapter->set($key, $value);
    }

    /**
     * @return array
     */
    public function getResTpl()
    {
        return $this->resTpl;
    }
}