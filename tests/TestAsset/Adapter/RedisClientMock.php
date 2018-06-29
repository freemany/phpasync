<?php

// Freeman Yam

namespace Pasync\Tests\TestAsset\Adapter;

class RedisClientMock
{
    protected $data = [];

    /**
     * @param string $key
     *
     * @return null|string
     */
    public function get(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param string $key
     *
     * @return int
     */
    public function del(string $key): int
    {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);

            return 1;
        }
        return 0;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool|null
     */
    public function set(string $key, string $value): ?bool
    {
        return $this->data[$key] = $value;
    }
}