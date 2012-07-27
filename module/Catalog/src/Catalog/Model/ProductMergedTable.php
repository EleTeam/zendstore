<?php

namespace Catalog\Model;

use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use ZendStore\Model\AbstractMergedTable;

class ProductMergedTable 
	extends AbstractMergedTable
{
	/**
	 * Get merged product
	 * 
	 * @param int $id product id
	 * @return ProductMergedRow
	 * @throws Exception\InvalidArgumentException
	 */
	public function getProductMergedRow($id)
	{
		$id  = (int) $id; 
		$pt  = $this->getJoinedTable('ProductTable')->getTable();
		$pdt = $this->getJoinedTable('ProductDescriptionTable')->getTable();
		
		$select = $this->sql->select()
			->from("$pt")
			->columns(array("*"))
			->join($pdt, "$pt.product_id = $pdt.product_id", array('description_id', 'description'), Select::JOIN_LEFT)
			->order("$pt.product_id DESC")
			->where("$pt.product_id = $id");
		
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$resultSet = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new ProductMergedRow());
		$resultSet->initialize($statement->execute());
		
		if (! $resultSet->count()) {
			throw new Exception\InvalidArgumentException("Not found merged product: $id");
		}
		
		return $resultSet->current();
	}	
	  
	/**
	 * Get merged products
	 * 
	 * @return ResultSet contains ProductMergedRow
	 */
	public function getProductMergedRows()
	{
		$pt  = $this->getJoinedTable('ProductTable')->getTable();
		$pdt = $this->getJoinedTable('ProductDescriptionTable')->getTable();
		
		$select = $this->sql->select()
			->from("$pt")
			->columns(array("*"))
			->join($pdt, "$pt.product_id = $pdt.product_id", array('description'), Select::JOIN_LEFT)
			->order("$pt.product_id DESC");
		
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$resultSet = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new ProductMergedRow());
		$resultSet->initialize($statement->execute());
		
		return $resultSet;
	}
	
	/**
	 * Save merged row
	 * 
	 * @param ProductMergedRow $productMergedRow
	 * @return bool
	 */
	public function saveProductMergedRow(ProductMergedRow $productMergedRow)
	{
		// Save Product
		$product 	  = new Product();
		$productTable = new ProductTable($this->adapter);
		$product->exchangeArray($productTable->filterByColumns($productMergedRow->toArray()));
		$productTable->saveProduct($product);
				
		// Save ProductDescription
		$productDescription 	 = new ProductDescription();
		$productDescriptionTable = new ProductDescriptionTable($this->adapter);
		$productDescription->exchangeArray($productDescriptionTable->filterByColumns($productMergedRow->toArray()));
		$productDescriptionTable->saveProductDescription($productDescription);
		
		return true;
	}
	
	public function deleteProductMergedRow()
	{
	
	}
	
	/**
	 * @see AbstractMergedTable::_initializeJoinedTables()
	 */
	protected function _initializeJoinedTables()
	{
		$this->joinedTables = array(
			'ProductTable' 				=> new ProductTable($this->adapter),
			'ProductDescriptionTable'	=> new ProductDescriptionTable($this->adapter),
		);
	}

}