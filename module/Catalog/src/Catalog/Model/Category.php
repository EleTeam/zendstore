<?php

namespace Catalog\Model;

use Zend\Db\RowGateway\AbstractRowGateway,
	Zend\InputFilter\InputFilterAwareInterface,
	Zend\InputFilter\InputFilterInterface,
	Zend\InputFilter\InputFilter,
	Zend\InputFilter\Factory as InputFactory;

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
			)));
			
			$this->setInputFilter($inputFilter);
		}	
		
		return $this->inputFilter;
	}
	
	/**
	 * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
	 */
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		$this->inputFilter = $inputFilter;
	}
	
	/**
	 * To array
	 * 
	 * @return array
	 * @todo Working with $form->bind($row);
	 */
	public function getArrayCopy()
	{
		return $this->toArray();
	}
}