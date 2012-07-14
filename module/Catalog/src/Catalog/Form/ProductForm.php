<?php

namespace Catalog\Form;

use Zend\Form\Form;

class ProductForm extends Form
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setName('product_form');
		$this->setAttributes(array(
			'method'  => 'post',
			'enctype' => 'multipart/form-data',
		));
		
		// product_id
		$this->add(array(
			'name'		 => 'product_id',
			'attributes' => array(
				'type'	=> 'hidden',	
			),		
		));
			
		// product_name
		$this->add(array(
			'name'		 => 'product_name',
			'attributes' => array(
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Product Name',
			),		
		));		
			
		// description
		$this->add(array(
			'name'		 => 'description',
			'attributes' => array(
				'type'	=> 'textarea',
			),
			'options' => array(
				'label'	=> 'Description',
			),		
		));		
			
		// store_price
		$this->add(array(
			'name'		 => 'store_price',
			'attributes' => array(
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Store Price',
			),		
		));

		// market_price
		$this->add(array(
			'name'		 => 'market_price',
			'attributes' => array(
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Market_price',
			),		
		));

		// brand
		$this->add(array(
			'name'		 => 'brand',
			'attributes' => array(
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Brand',
			),		
		));

		// quantity
		$this->add(array(
			'name'		 => 'quantity',
			'attributes' => array(
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Quantity',
			),		
		));

		// tags
		$this->add(array(
			'name'		 => 'tags',
			'attributes' => array(
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Tags',
			),		
		));

		// on_shelf
		$this->add(array(
			'name'		 => 'on_shelf',
			'attributes' => array(
				'type'	=> 'radio',
				'label'	=> 'On/Off shelf',
			),
			'options' => array(
				'options' => array(
					'On' => '1', 'Off' => 0,
				),
			)		
		));

		// category_id
		$this->add(array(
			'name'		 => 'category_id',
			'attributes' => array(
				'type'	=> 'input',
			),
			'options' => array(
				'label' => 'Category_id ???',
			),		
		));
		
		// link_id
		$this->add(array(
			'name'		 => 'link_id',
			'attributes' => array(
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Link_id ???',
			),	
		));
		
		// submit
		$this->add(array(
			'name'		 => 'submit',
			'attributes' => array(
				'type'	=> 'submit',
				'value'	=> 'Submit',
			),	
		));
			
		// reset
		$this->add(array(
			'name'		 => 'reset',
			'attributes' => array(
				'type'	=> 'reset',
				'value'	=> 'Reset',
			),	
		));
	}
}