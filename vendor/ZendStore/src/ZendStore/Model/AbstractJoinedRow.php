<?php

namespace ZendStore\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\RowGateway\RowGatewayInterface;

/**
 * A merged row would contain multiple entities 
 */
abstract class AbstractJoinedRow
	implements JoinedRowInterface, \ArrayAccess, \Countable
{
	/**
	 * @var string
	 */
	protected $isInitialized;
	
	/**
	 * @var array
	 */
	protected $joinedRows;
	
	/**
	 * @var array
	 */
	protected $originalData = array();
	
	/**
	 * @var array
	 */
	protected $data = array();
	
	public function __construct()
	{
		$this->initialize();
	}
	
	/**
	 * Initialization
	 */
	public function initialize()
	{
		if ($this->isInitialized) {
			return;
		}
	
		$this->_initializeJoinedRows();
	
		$this->isInitialized = true;
	}

	/**
	 * @see JoinedRowInterface::getJoinedRow()
	 */
	public function getJoinedRow($name)
	{
		if (! isset($this->joinedRows[$name])) {
			throw new Exception\JoinedRowNotFoundException("Not found the joined row: $name");
		}
	
		return $this->joinedRows[$name];
	}
	
	/**
	 * @see JoinedRowInterface::setJoinedRow()
	 */
	public function setJoinedRow($name, RowGatewayInterface $row)
	{
		$this->joinedRows[$name] = $row;
		return $this;
	}
	
	/**
	 * @see JoinedRowInterface::getJoinedRows()
	 */
	public function getJoinedRows()
	{
		return $this->joinedRows;
	}
	
    /**
     * @param mixed $array
     * @return array|void
     */
    public function exchangeArray($array)
    {
        return $this->populate($array, true);
    }

    /**
     * Populate Data
     *
     * @param  array $data
     * @param bool $isOriginal
     * @return AbstractFullModel
     */
    public function populate(array $data, $isOriginal = null)
    {
        $this->data = $data;
        if ($isOriginal || empty($this->originalData)) {
            $this->populateOriginalData($data);
        }

        return $this;
    }
	
    /**
     * Populate Original Data
     *
     * @param  array $originalData
     * @return AbstractFullModel
     */
    public function populateOriginalData(array $originalData)
    {
        $this->originalData = $originalData;
        return $this;
    }
	
	/**
	 * To array
	 *
	 *  @return array
	 */
	public function toArray()
	{
		return $this->data;
	}
	
	/**
	 * To array
	 * 
	 * @return array
	 */
	public function getArrayCopy()
	{
		return $this->data;
	}

	/**
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists($offset) 
	{
		return array_key_exists($offset, $this->data);		
	}

	/**
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet($offset) 
	{
		return $this->data[$offset];	
	}

	/**
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet($offset, $value) 
	{
		$this->data[$offset] = $value;
		return $this;		
	}

	/**
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset($offset) 
	{
		$this->data[$offset] = null;
		return $this;		
	}
	
	/**
	 * @see Countable::count()
	 */
	public function count() 
	{
		return count($this->data);		
	}

	public function __get($name)
	{
		if ($this->offsetExists($name)) {
			return $this->offsetGet($name);
		} else {
			throw new \InvalidArgumentException('Not a valid column in this full model: ' . $name);
		}
	}
	
	public function __set($name, $value)
	{
		$this->offsetSet($name, $value);
	}
	
	/**
	 * Initialize joined rows
	 *
	 * @return void
	 */
	protected function _initializeJoinedRows()
	{
		$this->joinedRows = array();
	}
	
}