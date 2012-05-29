<?php

namespace ZfcBase\Mapper;

use Zend\Db\Adapter\Adapter,
    Zend\Db\Adapter\AdapterAwareInterface,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Select,
    Zend\Db\ResultSet\ResultSet,
    InvalidArgumentException as CannotConvertToScalarException,
    InvalidArgumentException as NotArrayException;

abstract class DbAdapterMapper implements TransactionalInterface, AdapterAwareInterface
{
    /**
     * @var object
     */
    protected $modelPrototype = null;

    /**
     * @var array
     */
    private static $transactionCount = array();
    
    /**
     * Database adapter for read queries
     *
     * @var Zend\Db\Adapter\Adapter
     */
    protected $readAdapter;

    /**
     * Database adapter for write queries
     *
     * @var Zend\Db\Adapter\Adapter
     */
    protected $writeAdapter;
    
    private $tableGateways = array();

    public function selectWith(Select $select, $scrollable = true)
    {
        // Get the data
        $adapter = $this->getReadAdapter();
        $statement = $adapter->createStatement();
        $select->prepareStatement($adapter, $statement);
        $result = $statement->execute();

        if ($scrollable) {
            // Convert data to an array so we can iterate more than once
            $resultArray = array();
            foreach ($result as $row) {
                $resultArray[] = $this->toScalarValueArray($row);
            }
            $result = $resultArray;
        }

        // Create the ResultSet
        $resultSet = new ResultSet();
        $resultSet->setRowObjectPrototype($this->getModelPrototype());
        $resultSet->setDataSource($result);

        return $resultSet;
    }
    
    /**
     * @param string $tableName
     * @param bool $write
     * @return Zend\Db\TableGateway\TableGateway 
     */
    protected function getTableGateway($tableName, $write = false)
    {
        $typeStr = $write ? 'write' : 'read';
        
        //checks for existing instance
        if (isset($this->tableGateways[$typeStr][$tableName])) {
            return $this->tableGateways[$typeStr][$tableName];
        }
        
        $adapter = $write ? $this->getWriteAdapter() : $this->getReadAdapter();
        $tableGateway = new TableGateway($tableName, $adapter);
        
        //keep the instance
        $this->tableGateways[$typeStr][$tableName] = $tableGateway;
        
        return $tableGateway;
    }
    
    protected function toScalarValueArray($values)
    {
        //convert object to array first
        if (is_object($values)) {
            if(is_callable(array($values, 'toScalarValueArray'))) {
                return $values->toScalarValueArray();
            } elseif (is_callable(array($values, 'getArrayCopy'))) {
                $values = $values->getArrayCopy();
            } elseif (is_callable(array($values, 'toArray'))) {
                $values = $values->toArray();
            } elseif ($values instanceof \Traversable) {
                $v = array();
                foreach ($values as $key => $value) {
                    $v[$key] = $value;
                }
                $values = $v;
            } else {
                $values = get_object_vars($values);
            }
        }
        
        if (!is_array($values)) {
            throw new NotArrayException("Parameter is not an array");
        }
        
        $ret = array();
        foreach ($values as $key => $value) {
            if (is_scalar($value)) {
                $ret[$key] = $value;
                continue;
            }
            if (is_object($value)) {
                $ret[$key] = $this->convertObjectToScalar($value);
                continue;
            }
            if ($value == null) {
                $ret[$key] = null;
                continue;
            }
            
            throw new CannotConvertToScalarException("Can not convert '$key' key value to string");
        }
        
        return $ret;
    }
    
    protected function convertObjectToScalar($obj)
    {
        if (is_callable(array($obj, '__toString'))) {
            return $obj->__toString();
        }
        if ($obj instanceof \DateTime) {
            return $obj->format('Y-m-d\TH:i:s');
        }
        
        throw new CannotConvertToScalarException("Can not convert object '" . get_class($obj) . "' to string");
    }
    
    // Implement Transactional
    public function beginTransaction()
    {
        $this->performTransactionOperation('beginTransaction', $this->getWriteAdapter());
    }
    
    public function commit()
    {
        $this->performTransactionOperation('commit', $this->getWriteAdapter());
    }
    
    public function rollback()
    {
        $this->performTransactionOperation('rollback', $this->getWriteAdapter());
    }
    
    private function performTransactionOperation($operation, Adapter $adapter) 
    {
        $adapterHash = spl_object_hash($adapter);
        if (!isset(self::$transactionCount[$adapterHash])) {
            self::$transactionCount[$adapterHash] = 0;
        }
        
        switch ($operation) {
            case 'beginTransaction':
                if (self::$transactionCount[$adapterHash] == 0) {
                    $adapter->getDriver()->getConnection()->beginTransaction();
                }
                self::$transactionCount[$adapterHash]++;
                break;
            case 'commit':
                if (self::$transactionCount[$adapterHash] == 1) {
                    $adapter->getDriver()->getConnection()->commit();
                }
                self::$transactionCount[$adapterHash]--;
                break;
            case 'rollback':
                if (self::$transactionCount[$adapterHash] == 1) {
                    $adapter->getDriver()->getConnection()->rollback();
                }
                self::$transactionCount[$adapterHash]--;
                break;
        }
    }
    
    // Implement AdapterAwareInterface
    public function setDbAdapter(Adapter $adapter)
    {
        $this->setReadAdapter($adapter);
        $this->setWriteAdapter($adapter);
    }
    
    // getters/setters
    public function getReadAdapter()
    {
        return $this->readAdapter;
    }
    
    public function setReadAdapter(Adapter $readAdapter)
    {
        $this->readAdapter = $readAdapter;
        return $this;
    }
    
    public function getWriteAdapter()
    {
        return $this->writeAdapter;
    }

    public function setWriteAdapter(Adapter $writeAdapter)
    {
        $this->writeAdapter = $writeAdapter;
        return $this;
    }

    public function getModelPrototype()
    {
        return $this->modelPrototype;
    }

    public function setModelPrototype($modelPrototype)
    {
        $this->modelPrototype = $modelPrototype;
        return $this;
    }
}
