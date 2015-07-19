<?php namespace Clean\Repository;

interface CacheAdapterInterface
{
    /**
     * Caches specified callback result for specified time.
     *
     * @param string $key
     * @param callable $callable
     * @param integer $ttl
     *
     * @return mixed
     */
    public function cache($key, callable $callable, $ttl);
}
