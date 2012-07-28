<?php

namespace Catalog\Model;

use ZendStore\Model\AbstractJoinedRow;
use Catalog\Model\Product;
use Catalog\Model\ProductDescription;

class ProductJoinedRow extends AbstractJoinedRow
{
	protected function _initializeJoinedRows()
	{
		$this->joinedRows = array(
			'Product'			 => new Product(),
			'ProductDescription' => new ProductDescription(),	
		);
	}
}