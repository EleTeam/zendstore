<?php

namespace ZendStore\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

/**
 * A merged model would contain multiple models 
 */
abstract class AbstractMergedModel
	implements \ArrayAccess, \Countable
{
	/**
	 * @var array
	 */
	protected $originalData = array();
	
	/**
	 * @var array
	 */
	protected $data = array();

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
	
}