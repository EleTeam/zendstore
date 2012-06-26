<?php

namespace Catalog\Widget\Product;

use Zend\Http\Header\AbstractAccept;

use ZendStore\Widget\AbstractWidget;

class ProductWidget extends AbstractWidget
{
	/**
	 * @see AbstractWidget::_prepare()
	 */
	protected function _prepare()
	{
		$this->view->testVar = 'test value';
	}

}