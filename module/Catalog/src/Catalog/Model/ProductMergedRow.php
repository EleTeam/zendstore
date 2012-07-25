<?php

namespace Catalog\Model;

use ZendStore\Model\AbstractMergedRow;
use Catalog\Model\Product;
use Catalog\Model\ProductDescription;

class ProductMergedRow extends AbstractMergedRow
{
	protected function _initializeJoinedRows()
	{
		$this->joinedRows = array(
			'Product'			 => new Product(),
			'ProductDescription' => new ProductDescription(),	
		);
	}
}