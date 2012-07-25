<?php

namespace ZendStore\Model;

use Zend\Db\RowGateway\RowGatewayInterface;

interface MergedRowInterface
{
	/**
	 * Get a joined row
	 *
	 * @param string $name
	 * @return RowGatewayInterface
	 * @throws Exception\JoinedRowNotFoundException
	 */
	public function getJoinedRow($name);
	
	/**
	 * Set a joined row
	 *
	 * @param string $name
	 * @param RowGatewayInterface $row
	 * @return MergedRowInterface
	 */
	public function setJoinedRow($name, RowGatewayInterface $row);
	
	/**
	 * Get joinded rows
	 * 
	 * @return array
	 */
	public function getJoinedRows();
}