<?php

namespace ZendStore\Model;

use Zend\Db\TableGateway\AbstractTableGateway;

abstract class AbstractTable
	extends AbstractTableGateway
{
	/**
	 * Filter array by columns
	 * 
	 * @param array $array
	 * @return array The filtered array which contains this table's columns only
	 */
	public function filterByColumns(array $array)
	{
		$filteredArray = array();
		foreach ($array as $key => $value) {
			foreach ($this->columns as $column) {
				if ($key == $column) {
					$filteredArray[$key] = $array[$key];
				}
			}
		}
		
		return $filteredArray;
	}
}