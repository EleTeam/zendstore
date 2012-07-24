<?php

namespace Catalog\Model;

use ZendStore\Model\AbstractMergedEntity;

class MergedProduct extends AbstractMergedEntity
{
	/**
	 * @see AbstractMergedEntity::$data
	 */
	protected $data = array(
		'product_id'			=> null,
		'product_name'			=> null,
		'description'			=> null,
		'belongs_to_categories' => array(),
		'has_many_images' 		=> array(),	
	);

}