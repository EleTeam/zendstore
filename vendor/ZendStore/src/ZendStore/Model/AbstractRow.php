<?php

namespace ZendStore\Model;

use Zend\Db\RowGateway\AbstractRowGateway;

abstract class AbstractRow
	extends AbstractRowGateway
{
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