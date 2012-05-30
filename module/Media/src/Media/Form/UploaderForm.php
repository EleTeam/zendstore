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
		$this->setAttribute('enctype', 'multipart/form-data');
		
		$this->add(array(
			'name' => 'MAX_FILE_SIZE',
			'attributes' => array(
				'type'  => 'hidden',	
				'value' => '100000',
			),		
		));
		
		$this->add(array(
			'name' => 'uploadedfile',
			'attributes' => array(
				'type'  => 'file',
				'label' => 'Image',	
			),		
		));
		
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' 	=> 'submit',
				'value' => 'Upload',
			),	
		));
		
		$this->add(array(
			'name' => 'reset',
			'attributes' => array(
				'type'  => 'reset',
				'value'	=> 'Reset', 
			),		
		));
	}
}