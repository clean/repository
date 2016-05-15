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

    /**
     * Returns hash string generated based on current repository state
     * 
     * @return string
     */
    public function getHash()
    {
        return $this->repository->getHash();
    }

    /**
     * Invoke method from inside injected repository
     * 
     * @param string $method Name of the injected repository method being called
     * @param array $args Enumerated array with parameters passed to the $name'ed method
     * 
     * @return self
     */
    public function __call($name, $args)
    {
        if (!method_exists($this->repository, $name)) {
            throw new \RuntimeException(sprintf("Method %s doesn't exists in %s", $name, get_class($this->repository)));
        }

        if (false === call_user_func_array([$this->repository, $name], $args)) {
            throw new \RuntimeException('Method call failed');
        }
        return $this;
    }

    /**
     * Returns instance of injected repository
     * 
     * @return AbstractRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

   /**
    * Magic clone method
    * When cloning object, make also a clone of $this->repository
    *
    * @return void
    */
    public function __clone()
    {
        $this->repository = clone $this->repository;
    }
}
