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
		'store_price',		'market_price',		'tags',			'is_active',		'sort_order',
		'position',			'created_date',		'updated_date',				
	);
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new Product());
	
		$this->initialize();
	}
	
	/**
	 * Get a product
	 * 
	 * @param int $id
	 * @throws Exception\UnexpectedValueException
	 * @return Product
	 */
	public function getProduct($id)
	{
		$id = (int) $id;
		$resultSet = $this->select(array('product_id' => $id));
		$product   = $resultSet->current();
		if (! $product) {
			throw new Exception\UnexpectedValueException("Product $id doesn't exist");
		}
		
		return $product;
	}
	
	public function getProducts()
	{
		return $this->select();
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
		return $this->update($product->toArray(), array('product_id' => $product->product_id));
	}
}