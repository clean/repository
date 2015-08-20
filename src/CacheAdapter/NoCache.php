<?php namespace Clean\Repository\CacheAdapter;

use Clean\Repository\CacheAdapterInterface;

class NoCache implements CacheAdapterInterface
{

    /**
     * @see CacheAdapterInterface::cache()
     */
    public function cache($key, callable $callable, $ttl)
    {

        $result = call_user_func($callable);

        return $result;
    }
}
