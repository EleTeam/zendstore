<?php

namespace Catalog\Model;

use Zend\Db\RowGateway\AbstractRowGateway;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class Product extends AbstractRowGateway
	implements InputFilterAwareInterface
{
	/**
	 * @var InputFilter
	 */
	protected $inputFilter;
	
	/**
	 * @see InputFilterAwareInterface::getInputFilter()
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
				
			// store_price
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'store_price',
				'required'	 => true,	
				'validators' => array(
					array('name' => 'Float'),
				),				
			)));
				
			// market_price
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'market_price',
				'required'	 => false,	
				'filters'	 => array(
					array('name' => 'market_price'),
				),				
			)));
				
			// quantity
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'quantity',
				'required'	 => true,	
				'filters'	 => array(
					array('name' => 'Int'),
				),				
			)));
				
			// brand
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'brand',
				'required'	 => true,	
				'filters'	 => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags'),
				),				
			)));
				
			// type
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'type',
				'required'	 => true,	
				'filters'	 => array(
					array('name' => 'Int'),
				),				
			)));
				
			// is_active
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'is_active',
				'required'	 => true,	
				'filters'	 => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags'),
				),				
			)));
				
			// sort_order
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'sort_order',
				'required'	 => false,	
				'filters'	 => array(
					array('name' => 'Int'),
				),				
			)));
				
			// position
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'product_name',
				'required'	 => false,	
				'filters'	 => array(
					array('name' => 'Int'),
				),				
			)));
				
			// tags
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'tags',
				'required'	 => false,	
				'filters'	 => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags'),
				),				
			)));
				
			// created_date
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'created_date',
				'required'	 => false,
				'filters'	 => array(
					array('name' => 'Int'),	
				),	
			)));
			
			// updated_date
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'updated_date',
				'required'	 => false,
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