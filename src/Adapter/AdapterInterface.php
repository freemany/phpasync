<?php

// Freeman Yam. All Rights Reserved.

namespace Pasync\Adapter;

interface AdapterInterface
{
    /**
     * @param string $key
     *
     * @return null|string
     */
    public function get(string $key): ?string;

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool|null
     */
    public function set(string $key, string $value): ?bool;

    /**
     * @param string $key
     *
     * @return int
     */
    public function del(string $key): int;
}