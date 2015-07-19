<?php namespace Clean\Repository\CacheAdapter;

use Clean\Repository\CacheAdapterInterface;
use Metaphore\Cache;

class Metaphore implements CacheAdapterInterface
{
    /**
     * @var Cache
     */
    private $backend;

    /**
     * @param Cache $backend
     *
     * @return void
     */
    public function __construct(Cache $backend)
    {
        $this->backend = $backend;
    }

    /**
     * @see CacheAdapterInterface::cache()
     */
    public function cache($key, callable $callable, $ttl)
    {
        return $this->backend->cache($key, $callable, $ttl);
    }
}
