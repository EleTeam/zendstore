<?php

namespace Catalog\Model;

use ZendStore\Model\AbstractMergedModel;

class MergedProduct extends AbstractMergedModel
{
	/**
	 * @see AbstractMergedModel::$data
	 */
	protected $data = array(
		'product_id'			=> null,
		'product_name'			=> null,
		'description'			=> null,
		'belongs_to_categories' => array(),
		'has_many_images' 		=> array(),	
	);

}