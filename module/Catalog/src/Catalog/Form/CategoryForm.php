<?php

namespace Catalog\Form;

use Zend\Form\Form;

class CategoryForm extends Form
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setName('category_edit_form');
		$this->setAttribute('method', 'post');
		
		// category_id
		$this->add(array(
			'name'		 => 'category_id',
			'attributes' => array(
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
				'type'	=> 'input',
				'label'	=> 'Category Name',	
			),		
		));	

		// is_active
		$this->add(array(
			'name'		 => 'is_active',
			'attributes' => array(
				'type'	=> 'input',
				'label'	=> 'Is Active',	
			),		
		));

		// discription
		$this->add(array(
			'name'		 => 'discription',
			'attributes' => array(
				'type'	=> 'input',
				'label'	=> 'Discription',	
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
