<?php namespace Clean\Repository;

class CacheProxy extends AbstractRepository
{
    /**
     * @var CacheAdapterInterface
     */
    protected $adapter;

    /**
     * @var AbstractRepository
     */
    protected $repository;

    /**
     * @var integer TTL value for cache in seconds
     */
    protected $ttl;

    /**
     * Constructs CacheProxy object
     *
     * @param CacheAdapterInterface $cache cache
     * @param AbstractRepository $repository repository
     */
    public function __construct(CacheAdapterInterface $cache, AbstractRepository $repository)
    {
        $this->adapter = $cache;
        $this->repository = $repository;
    }

    /**
     * Sets ttl value for cache
     *
     * @param $ttl int Cache time in seconds
     * @return self
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * Returns cached data
     *
     * @return mixed
     */
    public function assemble()
    {
        return $this->adapter->cache(
            $this->getHash(),
            function () {
                return $this->repository->assemble();
            },
            $this->ttl
        );
    }

    public function getHash()
    {
        return $this->repository->getHash();
    }
}
