<?php

namespace ZendStore\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

/**
 * A joined table would contain multiple tables 
 */
abstract class AbstractJoinedTable implements JoinedTableInterface
{
	/**
	 * @var array
	 */
	protected $joinedTables;
	
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
	
	/**
	 * Initialization
	 */
	public function initialize()
	{
		if ($this->isInitialized) {
			return;
		}
	
		if (! $this->sql instanceof Sql) {
			$this->sql = new Sql($this->adapter);
		}
	
		$this->_initializeJoinedTables();
		
		$this->isInitialized = true;
	}
	
	/**
	 * @see JoinedTableInterface::getJoinedTable()
	 */
	public function getJoinedTable($name) 
	{
		if (! isset($this->joinedTables[$name])) {
			throw new Exception\JoinedTableNotFoundException("Not found the joined table: $name");
		}
		if (! $this->joinedTables[$name] instanceof TableGatewayInterface) {
			throw new Exception\InvalidJoinedTableException("Invalid joined table: $name");
		}
		
		return $this->joinedTables[$name];
	}

	/**
	 * @see JoinedTableInterface::getJoinedTables()
	 */
	public function getJoinedTables() 
	{
		return $this->joinedTables;
	}

	/**
	 * @see JoinedTableInterface::setJoinedTable()
	 */
	public function setJoinedTable($name, TableGatewayInterface $table) 
	{
		$this->joinedTables[$name] = $table;
		return $this;
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
	
	/**
	 * Initialize joined tables
	 * 
	 * @return void
	 */
	protected function _initializeJoinedTables()
	{
		$this->joinedTables = array();
	}
	
}