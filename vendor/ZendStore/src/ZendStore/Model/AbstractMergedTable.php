<?php

namespace ZendStore\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

/**
 * A merged table would contain multiple tables 
 */
abstract class AbstractMergedTable
{
	/**
	 * @var bool
	 */
	protected $isInitialized;
	
	/**
	 * @var Adapter
	 */
	protected $adapter;
	
	/**
	 * @var Sql
	 */
	protected $sql;
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->initialize();
	}
	
	public function initialize()
	{
		if ($this->isInitialized) {
			return;
		}
	
		if (!$this->sql instanceof Sql) {
			$this->sql = new Sql($this->adapter);
		}
	
		$this->isInitialized = true;
	}
	
	/**
	 * Get adapter
	 *
	 * @return Adapter
	 */
	public function getAdapter()
	{
		return $this->adapter;
	}
	
	/**
	 * @return Sql
	 */
	public function getSql()
	{
		return $this->sql;
	}
	
}