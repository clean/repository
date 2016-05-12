<?php namespace Clean\Repository;

abstract class AbstractRepository
{
    protected $criteria = [];

    /**
     * Process data collection
     * 
     * 
     * @return mixed
     */
    abstract public function assemble();

    /**
     * Returns unique hash based on current repository state
     * 
     * 
     * @return string
     */
    abstract public function getHash();

    /**
     * Sets specified criteria that will be used in assembling process
     *
     * @param string $criteriaName Name of criteria to be set
     * @param mixed $criteria
     *
     * @return self
     */
    public function setCriteria($criteriaName, $criteria)
    {
        $this->criteria[$criteriaName] = $criteria;
        return $this;
    }

    /**
     * Sets base criteria
     *
     * @param mixed $criteria criteria
     *
     * @return self
     */
    public function setBaseCriteria($criteria)
    {
        $this->setCriteria('base', $criteria);
        return $this;
    }

    /**
     * Returns base criteria
     *
     * @return mixed
     */
    public function getBaseCriteria()
    {
        return $this->getCriteria('base');
    }

    /**
     * Returns true if criteria with specified name exists
     *
     * @param string $name Name of the criteria to check
     *
     * @return bool
     */
    protected function hasCriteria($name)
    {
        return isset($this->criteria[$name]);
    }

    /**
     * Returns criteria by name or false otherwise
     * 
     * @param string $name name 
     * 
     * @return mixed
     */
    protected function getCriteria($name)
    {
        return isset($this->criteria[$name]) ? $this->criteria[$name] : false;
    }

    /**
     * Invoke methods provided in associative array
     *
     * @param array $params params 
     * 
     * @return self
     */
    protected function invoke($params)
    {
        if ($params) {
            foreach ($params as $methodName => $param) {
                $this->$methodName($param);
            }
        }
        return $this;
    }

    /**
     * Returns array of criterias used by repository recursively
     *
     * @param AbstractRepository $repository repository
     *
     * @returns array of criteria objects
     */
    protected function collectCriteria(AbstractRepository $repository)
    {
        $result = array();
        foreach ($repository->criteria as $key => $criteria) {
            if ($criteria instanceof AbstractRepository) {
                foreach ($this->collectCriteria($criteria) as $items) {
                    $result[] = $items;
                }
            } else {
                $result[] = $criteria;
            }
        }
        return $result;
    }
}
