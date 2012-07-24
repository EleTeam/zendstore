<?php

namespace Catalog\Model;

use Zend\Db\RowGateway\AbstractRowGateway,
	Zend\InputFilter\InputFilterAwareInterface,
	Zend\InputFilter\InputFilterInterface,
	Zend\InputFilter\InputFilter,
	Zend\InputFilter\Factory as InputFactory;

class Product extends AbstractRowGateway
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
			
			// product_id
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'product_id',
				'required'	 => true,
				'filters'	 => array(
					array('name' => 'Int'),	
				),	
			)));
			
			// product_name
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'product_name',
				'required'	 => true,	
				'filters'	 => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags'),
				),				
			)));			
				
			// created_date
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'created_date',
				'required'	 => true,
				'filters'	 => array(
					array('name' => 'Int'),	
				),	
			)));
			
			// updated_date
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'updated_date',
				//'required'	 => true,
				'filters'	 => array(
					array('name' => 'Int'),	
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