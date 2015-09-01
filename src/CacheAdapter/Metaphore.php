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
     */
    public function __construct(Cache $backend, $prefix = '')
    {
        $this->backend = $backend;
        $this->prefix = $prefix;
    }

    /**
     * @see CacheAdapterInterface::cache()
     */
    public function cache($key, callable $callable, $ttl)
    {
        return $this->backend->cache($this->prefix.$key, $callable, $ttl);
    }
}
