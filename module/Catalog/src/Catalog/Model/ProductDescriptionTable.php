<?php

namespace Catalog\Model;

use ZendStore\Model\AbstractTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class ProductDescriptionTable extends AbstractTable
{
	/**
	 * @var string
	 */
	protected $table = 'catalog_product_description';

	/**
	 * @var array
	 */
	protected $columns = array(
		'description_id',	'product_id',		'description',
	);
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new ProductDescription());
	
		$this->initialize();
	}
	
	/**
	 * Add or update a product's description
	 * 
	 * @param ProductDescription $productDescription
	 * @return int
	 */
	public function saveProductDescription(ProductDescription $productDescription)
	{
		if (empty($productDescription->description_id)) {
			return $this->addProductDescription($productDescription);
		} else {
			return $this->updateProductDescription($productDescription);
		}
	}
	
	/**
	 * Add a product description
	 * 
	 * @param ProductDescription $productDescription
	 * @return int
	 */
	public function addProductDescription(ProductDescription $productDescription)
	{
		return $this->insert($productDescription->toArray());
	}
	
	/**
	 * Update a product description
	 * 
	 * @param ProductDescription $productDescription
	 * @return int
	 */
	public function updateProductDescription(ProductDescription $productDescription)
	{
		return $this->update($productDescription->toArray(), 
					array(
						'description_id' => $productDescription->description_id, 
						'product_id' 	 => $productDescription->product_id
					));
	}
	
	/**
	 * Delete a product description
	 *
	 * @param int $id Product id
	 * @return int
	 */
	public function deleteProductDescriptionByProductId($id)
	{
		$id = (int) $id;
		return $this->delete(array('product_id' => $id));
	}
}