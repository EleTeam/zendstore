<?php

namespace Catalog\Model;

use ZendStore\Model\AbstractMergedTable;

class MergedProductTable extends AbstractMergedTable
{
	public function getMergedProduct()
	{
		
	}
	
	/**
	 * Save merged model
	 * 
	 * @param MergedProduct $mergedProduct
	 * @return bool
	 */
	public function saveMergedProduct(MergedProduct $mergedProduct)
	{
		// Save Product
		$product	  = new Product();
		$productTable = new ProductTable($this->adapter);
		$product->exchangeArray($mergedProduct->toArray());
		$productTable->saveProduct($product);
		
		// Save ProductDescription
		$productDescription 	 = new ProductDescription();
		$productDescriptionTable = new ProductDescriptionTable($this->adapter);
		$productDescription->exchangeArray($mergedProduct->toArray());
		$productDescriptionTable->saveProductDescription($droductDescription);
		
		return true;
	}
	
	public function deleteMergedProduct()
	{
	
	}

}