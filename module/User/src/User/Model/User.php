<?php

namespace User\Model;

use Zend\Db\ResultSet\Row,
	Zend\InputFilter\InputFilter,
	Zend\InputFilter\InputFilterAwareInterface;
	

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