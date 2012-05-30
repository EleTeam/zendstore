<?php

namespace Media\Form;

use Zend\Form\Form;

class UploaderForm extends Form
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setName('uploader');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
				'type' => 'hidden',	
			),		
		));
		
		$this->add(array(
			'name' => 'file',
			'attributes' => array(
				'type'  => 'file',
				'label' => 'Image',	
			),		
		));
		
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' 	=> 'submit',
				'id'	=> 'submitbutton',
				'value' => 'Submit',
			),	
		));
		
		$this->add(array(
			'name' => 'reset',
			'attributes' => array(
				'type'  => 'reset',
				'id'    => 'resetbutton',
				'value'	=> 'Reset', 
			),		
		));
	}
}