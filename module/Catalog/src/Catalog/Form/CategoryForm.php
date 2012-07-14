<?php

namespace Catalog\Form;

use Zend\Form\Form;

class CategoryForm extends Form
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setName('category_form');
		$this->setAttributes(array(
			'method'  => 'post',
			'enctype' => 'multipart/form-data',		
		));
		
		// category_id
		$this->add(array(
			'name'		 => 'category_id',
			'attributes' => array(
				'id'	=> 'category_id',
				'type'	=> 'hidden',	
			),		
		));	
			
		// parent_id
		$this->add(array(
			'name'		 => 'parent_id',
			'attributes' => array(
				'type'	=> 'hidden',
			),		
		));
			
		// category_name
		$this->add(array(
			'name'		 => 'category_name',
			'attributes' => array(
				'id'	=> 'category_name',
				'class' => 'input-text required-entry',
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Category Name',
			),		
		));	

		// is_active
		$this->add(array(
			'name'		 => 'is_active',
			'attributes' => array(
				'id'	=> 'is_active',
				'type'	=> 'input',
			),
			'options' => array(
				'label'	=> 'Is Active',
			),		
		));

		// description
		$this->add(array(
			'name'		 => 'description',
			'attributes' => array(
				'id'	=> 'description',
				'class' => 'textarea',
				'type'	=> 'textarea',
			),
			'options' => array(
				'label'	=> 'Description',
			),		
		));
		
		// submit
		$this->add(array(
			'name'		 => 'submit',
			'attributes' => array(
				'type'	=> 'submit',
				'value'	=> 'Save',
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
