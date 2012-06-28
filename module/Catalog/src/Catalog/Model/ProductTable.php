<?php

namespace Catalog\Model;

use Zend\Db\TableGateway\AbstractTableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\ResultSet\ResultSet;

class ProductTable extends AbstractTableGateway
{
	/**
	 * @var string
	 */
	protected $table = 'catalog_product';

	/**
	 * @var array
	 */
	protected $columns = array(
		'product_id',		'product_name',		'type',			'quantity',			'brand',
		'price',			'market_price',		'tags',			'on_shelf',			'sort_order',
		'posistion',		'created_at',		'updated_at'				
	);
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet(new Product());
	
		$this->initialize();
	}
	
	/**
	 * Get a product
	 * 
	 * @param int $productId
	 * @throws Exception\UnexpectedValueException
	 * @return Product
	 */
	public function getProduct($id)
	{
		$id = (int) $id;
		$resultSet = $this->select(array('product_id' => $id));
		$row 	   = $resultSet->current();
		if (! $row) {
			throw new Exception\UnexpectedValueException("Product $id doesn't exist");
		}
		
		return new Product($row->getArrayCopy());
	}
	
	/**
	 * Add or update a product
	 * 
	 * @param Product $product
	 * @return int
	 */
	public function saveProduct(Product $product)
	{
		if ($product->product_id) {
			return $this->updateProduct($product);
		} else {
			return $this->addProduct($product);
		}
	}
	
	/**
	 * Add a product
	 * 
	 * @param Product $product
	 * @return int
	 */
	public function addProduct(Product $product)
	{
		return $this->insert($product->toArray());
	}
	
	/**
	 * Update a product
	 * 
	 * @param Product $product
	 * @return int
	 */
	public function updateProduct(Product $product)
	{
		return $this->update($product->toArray(), $product->product_id);
	}
}