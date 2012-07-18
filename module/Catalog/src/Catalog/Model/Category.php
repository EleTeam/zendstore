<?php

namespace Catalog\Model;

use Zend\Db\RowGateway\AbstractRowGateway;
use	Zend\InputFilter\InputFilter;
use	Zend\InputFilter\Factory as InputFactory;
use	Zend\InputFilter\InputFilterAwareInterface;
use	Zend\InputFilter\InputFilterInterface;

class Category extends AbstractRowGateway 
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
				'name'		 => 'category_id',
				'required'	 => true,
				'filters'	 => array(
					array('name' => 'Int'),	
				),	
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'		 => 'category_name',
				'required'	 => true,
				'filters'	 => array(
					array('name' => 'StripTags'),
					array('name' => 'stringTrim'),	
				),					
				'validators' => array(
					array(
						'name' 	  => 'StringLength',
						'options' => array(
							'encoding' 	=> 'UTF-8',
							'min'		=> 1,
							'max'		=> 100,	
						),
					),	
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}	
		
		return $this->inputFilter;
	}
	
	/**
	 * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
	 * @throws 
	 */
	
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