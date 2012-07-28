<?php

namespace Catalog\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Catalog\Model\ProductJoinedRow;

class ProductForm extends Form
{
	public function __construct()
	{
		parent::__construct('product_form');
		
		$this->setAttributes(array(
			'method'  => 'post',
			'enctype' => 'multipart/form-data',
		));
		
		/*** product table's columns ***/
		// product_id
		$this->add(array(
			'name'		 => 'product_id',
			'attributes' => array(
				'id'	=> 'product_id',
				'type'	=> 'hidden',	
			),		
		));
			
		// product_name
		$this->add(array(
			'name'		 => 'product_name',
			'attributes' => array(
				'id'	=> 'product_name',
				'type'	=> 'text',
			),
			'options' => array(
				'label'	=> 'Product Name',
			),		
		));		
			
		// store_price
		$this->add(array(
			'name'		 => 'store_price',
			'attributes' => array(
				'type'	=> 'text',
			),
			'options' => array(
				'label'	=> 'Store Price',
			),		
		));

		// market_price
		$this->add(array(
			'name'		 => 'market_price',
			'attributes' => array(
				'type'	=> 'text',
			),
			'options' => array(
				'label'	=> 'Market_price',
			),		
		));

		// quantity
		$this->add(array(
			'name'		 => 'quantity',
			'attributes' => array(
				'type'	=> 'text',
			),
			'options' => array(
				'label'	=> 'Quantity',
			),		
		));

		// brand
		$this->add(array(
			'name'		 => 'brand',
			'attributes' => array(
				'type'	=> 'text',
			),
			'options' => array(
				'label'	=> 'Brand',
			),		
		));
			
		// type
		$this->add(array(
			'name'		 => 'type',
			'attributes' => array(
				'type'	=> 'text',
			),
			'options' => array(
				'label'	=> 'Product Type',
			),		
		));	

		// is_active
		$this->add(array(
			'name'		 => 'is_active',
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

		// tags
		$this->add(array(
			'name'		 => 'tags',
			'attributes' => array(
				'type'	=> 'text',
			),
			'options' => array(
				'label'	=> 'Tags',
			),		
		));
			
		/*** product_description table's columns ***/

		// description_id
		$this->add(array(
			'name'		 => 'description_id',
			'attributes' => array(
				'id'	=> 'description_id',
				'type'	=> 'hidden',
			),
		));
		
		// description
		$this->add(array(
			'name'		 => 'description',
			'attributes' => array(
				'id'	=> 'description',
				'type'	=> 'textarea',
			),
			'options' => array(
				'label'	=> 'Description',
			),		
		));

		// category_id
		$this->add(array(
			'name'		 => 'category_id',
			'attributes' => array(
				'type'	=> 'text',
			),
			'options' => array(
				'label' => 'Category_id ???',
			),		
		));
		
		/*** product_link table's columns ***/
		// link_id
		$this->add(array(
			'name'		 => 'link_id',
			'attributes' => array(
				'type'	=> 'text',
			),
			'options' => array(
				'label'	=> 'Link_id ???',
			),	
		));
		
		/*** Submit buttons ***/
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
		
		$this->_initializeInputFilter();
	}
	
	protected function _initializeInputFilter()
	{
		$mergedRow	= new ProductJoinedRow();
		$pFilter	= $mergedRow->getJoinedRow('Product')->getInputFilter();
		$pdFilter	= $mergedRow->getJoinedRow('ProductDescription')->getInputFilter();
		
		$inputFilter = new InputFilter();
		$factory	 = new InputFactory();
				
		/*** product table's columns ***/
		$inputFilter->add($pFilter->get('product_id'));
		$inputFilter->add($pFilter->get('product_name'));
		$inputFilter->add($pFilter->get('store_price'));
		$inputFilter->add($pFilter->get('market_price'));
		/*** product_description table's columns ***/
		$inputFilter->add($pdFilter->get('description_id'));
		$inputFilter->add($pdFilter->get('description'));
		
		$this->filter = $inputFilter;
	}
	
}