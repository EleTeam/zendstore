<?php

namespace Base\Widget;

interface WidgetInterface
{
	/**
	 * Return widget content
	 * 
	 * @return string
	 */
	public function display();
}