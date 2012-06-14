<?php

namespace User\Form;

use Zend\Form\Form;

class UserForm extends Form
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setName('user_form');
		$this->setAttribute('method', 'post');
		
		// user_id
		$this->add(array(
			'name'		 => 'user_id',
			'attributes' => array(
				'type' => 'hidden',
			),	
		));
		
		// email
		$this->add(array(
			'name'		 => 'email',
			'attributes' => array(
				'type' 	=> 'input',
				'label'	=> 'Email',	
			),		
		));
		
		// password
		$this->add(array(
			'name'		 => 'password',
			'attributes' => array(
				'type'	=> 'input',
				'label' => 'Password',	
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
				'value' => 'Reset',					
			),	
		));
	}
}