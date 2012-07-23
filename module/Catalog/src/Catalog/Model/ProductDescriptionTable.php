<?php

namespace Catalog\Model;

use Zend\Db\TableGateway\AbstractTableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\ResultSet\ResultSet;

class ProductDescriptionTable extends AbstractTableGateway
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
	 * @param ProductDescription $droductDescription
	 * @return int
	 */
	public function saveProductDescription(ProductDescription $droductDescription)
	{
		if ($droductDescription->description_id) {
			return $this->updateProductDescription($droductDescription);
		} else {
			return $this->addProductDescription($droductDescription);
		}
	}
	
	/**
	 * Add a product description
	 * 
	 * @param ProductDescription $droductDescription
	 * @return int
	 */
	public function addProductDescription(ProductDescription $droductDescription)
	{
		return $this->insert($droductDescription->toArray());
	}
	
	/**
	 * Update a product description
	 * 
	 * @param ProductDescription $droductDescription
	 * @return int
	 */
	public function updateProductDescription(ProductDescription $droductDescription)
	{
		return $this->update($droductDescription->toArray(), array('description_id' => $droductDescription->description_id));
	}
}