<?php

namespace Catalog\Model;

use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use ZendStore\Model\AbstractJoinedTable;

class ProductJoinedTable 
	extends AbstractJoinedTable
{
	/**
	 * Get joined product
	 * 
	 * @param int $id product id
	 * @return ProductJoinedRow
	 * @throws Exception\InvalidArgumentException
	 */
	public function getProductJoinedRow($id)
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
		$resultSet = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new ProductJoinedRow());
		$resultSet->initialize($statement->execute());
		
		if (! $resultSet->count()) {
			throw new Exception\InvalidArgumentException("Not found joined product: $id");
		}
		
		return $resultSet->current();
	}	
	  
	/**
	 * Get joined products
	 * 
	 * @return ResultSet contains ProductJoinedRow
	 */
	public function getProductJoinedRows()
	{
		$pt  = $this->getJoinedTable('ProductTable')->getTable();
		$pdt = $this->getJoinedTable('ProductDescriptionTable')->getTable();
		
		$select = $this->sql->select()
			->from("$pt")
			->columns(array("*"))
			->join($pdt, "$pt.product_id = $pdt.product_id", array('description'), Select::JOIN_LEFT)
			->order("$pt.product_id DESC");
		
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$resultSet = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new ProductJoinedRow());
		$resultSet->initialize($statement->execute());
		
		return $resultSet;
	}
	
	/**
	 * Save joined row
	 * 
	 * @param ProductJoinedRow $productJoinedRow
	 * @return void
	 */
	public function saveProductJoinedRow(ProductJoinedRow $productJoinedRow)
	{
		// Save Product
		$product 	  = new Product();
		$productTable = new ProductTable($this->adapter);
		$product->exchangeArray($productTable->filterByColumns($productJoinedRow->toArray()));
		$productTable->saveProduct($product);
		if ($productId = $productTable->getLastInsertValue()) { // Add product
			$productJoinedRow->product_id = $productId;
		}
				
		// Save ProductDescription
		$productDescription 	 = new ProductDescription();
		$productDescriptionTable = new ProductDescriptionTable($this->adapter);
		$productDescription->exchangeArray($productDescriptionTable->filterByColumns($productJoinedRow->toArray()));
		$productDescriptionTable->saveProductDescription($productDescription);
	}
	
	/**
	 * Delete a joined product
	 * 
	 * @param int $id Product id
	 * @return void
	 */
	public function deleteProductJoinedRow($id)
	{
		$id = (int) $id;
		$this->getJoinedTable('ProductTable')->deleteProduct($id);
		$this->getJoinedTable('ProductDescriptionTable')->deleteProductDescriptionByProductId($id);
	}
	
	/**
	 * @see AbstractJoinedTable::_initializeJoinedTables()
	 */
	protected function _initializeJoinedTables()
	{
		$this->joinedTables = array(
			'ProductTable' 				=> new ProductTable($this->adapter),
			'ProductDescriptionTable'	=> new ProductDescriptionTable($this->adapter),
		);
	}

}