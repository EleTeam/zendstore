<?php

namespace Geography\Model;

use Zend\Db\TableGateway\AbstractTableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\ResultSet\ResultSet;

class RegionTable extends AbstractTableGateway
{
	/**
	 * @var string
	 */
	protected $table = 'geography_region';
	
	/**
	 * @var array
	 */
	protected $columns = array();
	
	/**
	 * Constructor
	 * 
	 * @param $adapter
	 */
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet(new Region());
		
		$this->initialize();
	}
	
	public function getRegion($regionId)
	{
		
	}
	
	/**
	 * Get sub-regions
	 * 
	 * @param int $regionId
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function getChildren($regionId = 0)
	{
		$regionId = (int)$regionId;
		$resultSet = $this->select("parent_id = $regionId");
		return $resultSet;
	}
}