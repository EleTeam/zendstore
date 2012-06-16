<?php

namespace User\Model;

use Zend\Db\ResultSet\Row,
	Zend\InputFilter\InputFilter,
	Zend\InputFilter\InputFilterAwareInterface,
	Zend\InputFilter\InputFilterInterface,
	Zend\InputFilter\Factory as InputFactory;
	

class User extends Row
	implements InputFilterAwareInterface
{
	/**
	 * @var InputFilter
	 */
	protected $inputFilter;
	
	/**
	 * @see Zend\InputFilter.InputFilterAwareInterface::getInputFilter()
	 */
	public function getInputFilter() 
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'		=> 'user_id',
			//	'required'	=> true,
				'filters'	=> array(
					array('name' => 'Int'),	
				),		
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'email',
				'required'	 => true,
				'validators' => array(
					array(
						'name'	  => 'EmailAddress',
					),	
				),		
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'password',
				'required'	 => true,
				'validators' => array(
					array(
						'name'	  => 'StringLength',
						'options' => array(
							'endcoding' => 'UTF-8',
							'min'		=> 6,
							'max'		=> 32,	
						),		
					),
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}

	/**
	 * @see Zend\InputFilter.InputFilterAwareInterface::setInputFilter()
	 */
	public function setInputFilter(InputFilterInterface $inputFilter) 
	{
		
	}
	
}