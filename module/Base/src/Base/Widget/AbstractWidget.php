<?php

namespace Base\Widget;

use Base\Widget\WidgetInterface;
use Zend\View\Helper\AbstractHelper;

class AbstractWidget extends AbstractHelper
	implements WidgetInterface
{
	public function __construct()
	{
		$this->init();
	}
	
	public function init()
	{
		
	}
	
	/**
	 * @see WidgetInterface::display()
	 */
	public function display()
	{
		$content = 'Default widget content';
			
		return $content;
	}
	
}