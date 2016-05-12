<?php namespace Example\Chinook;

use Aura\SqlQuery\QueryFactory;
use Aura\Sql\ExtendedPdo;


class AbstractRepository extends \Clean\Repository\AbstractRepository
{
    public function __construct()
    {
        $this->setBaseCriteria((new QueryFactory('sqlite'))->newSelect());
    }

    public function assemble()
    {
        $db = $this->getDbConnection();
        $select = $this->getBaseCriteria();
        $result = $db->fetchAll($select->getStatement(), $select->getBindValues());
        $collection = $this->getNewCollection();
        foreach ($result as $row) {
            $collection->append($this->getNewEntity($row));
        }

        return $collection;
    }

    public function getHash()
    {
        $hash = '';
        foreach ($this->collectCriteria($this) as $select) {
            $hash .= $select->getStatement() . serialize($select->getBindValues());
        }
        return sha1($hash);
    }

    public function limit($limit)
    {
        $this->getBaseCriteria()
            ->limit($limit);
        return $this;
    }

    protected function getNewEntity($data = [])
    {
        $namespace = $this->getNamespace();
        $className = '\\' . $namespace . '\\Entity';
        return new $className($data);
    }

    protected function getNewCollection()
    {
        $namespace = $this->getNamespace();
        $className = '\\' . $namespace . '\\Collection';
        return new $className();
    }

    private function getNamespace()
    {
        $reflection = new \ReflectionClass($this);
        return $reflection->getNamespaceName();
    }

    private function getDbConnection()
    {
        static $db;

        if (!$db) {
            $db = new ExtendedPdo(sprintf('sqlite:%s',__DIR__.'/chinook.db'));
        }

        return $db;
    }
}
