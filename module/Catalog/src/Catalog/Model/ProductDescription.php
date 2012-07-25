<?php

namespace Catalog\Model;

use Zend\Db\RowGateway\AbstractRowGateway,
	Zend\InputFilter\InputFilterAwareInterface,
	Zend\InputFilter\InputFilterInterface,
	Zend\InputFilter\InputFilter,
	Zend\InputFilter\Factory as InputFactory;

class ProductDescription extends AbstractRowGateway
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
			
			// description_id
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'description_id',
				'required'	 => true,
				'filters'	 => array(
					array('name' => 'Int'),	
				),	
			)));
			
			// product_id
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'product_id',
				'required'	 => true,
				'filters'	 => array(
					array('name' => 'Int'),	
				),	
			)));
			
			// description
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'description',
				'required'	 => true,	
				'filters'	 => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),	
				),				
			)));		
			
			$this->inputFilter = $inputFilter;
		}	
		
		return $this->inputFilter;
	}
	
	/**
	 * @see Zend\InputFilter.InputFilterAwareInterface::setInputFilter()
	 * @throws Exception\BadMethodCallException
	 */
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new Exception\BadMethodCallException('The method does not suppose to be invoke');
	}
	
	/**
	 * To array
	 *
	 * @return array
	 * @todo Working with $form->bind($object);
	 */
	public function getArrayCopy()
	{
		return $this->toArray();
	}
}