<?php

namespace Geography\Model;

use Zend\Db\TableGateway\AbstractTableGateway;

class RegionTable extends AbstractTableGateway
{
	/**
	 * @var string
	 */
	protected $table = 'region';
	
	/**
	 * @var 
	 */
	protected $adapter = '';
	
	/**
	 * @var array
	 */
	protected $columns = array();
	
	public function getRegion
}