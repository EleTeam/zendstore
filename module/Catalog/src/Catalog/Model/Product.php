<?php

namespace Catalog\Model;

use Zend\Text\Table\Row,
	Zend\InputFilter\InputFilterAwareInterface,
	Zend\InputFilter\InputFilterInterface,
	Zend\InputFilter\InputFilter,
	Zend\InputFilter\Factory as InputFactory;

class Product extends Row
	implements InputFilterAwareInterface
{
	/**
	 * @var InputFilter
	 */
	protected $inputFilter;
	
	/**
	 * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
	 */
	public function getInputFilter()
	{
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory	 = new InputFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'product_id',
				'required'	 => true,
				'filters'	 => array(
					array('name' => 'Int'),	
				),	
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'product_name',
				'required'	 => true					
			)));
		}	
		
		return $this->inputFilter;
	}
	
	/**
	 * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
	 */
	public function setInputFilter(InputFilterInterface $inputFilter)
	{}
}