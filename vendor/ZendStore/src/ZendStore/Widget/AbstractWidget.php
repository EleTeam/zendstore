<?php

namespace ZendStore\Widget;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

use ZendStore\Widget\WidgetInterface;

abstract class AbstractWidget extends AbstractHelper
	implements WidgetInterface
{
	/**
	 * Widget template file
	 * 
	 * @var string
	 */
	protected $_template;
	
	/**
	 * Widget content
	 * 
	 * @var string
	 */
	protected $_content;
	
	/**
	 * Prepare variables for view template
	 */
	abstract protected function _prepare();
	
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Render and retrieve widget content and store in $this->_content
	 * 
	 * @return string
	 */
	public function __invoke()
	{
		$this->content = $this->render();
		
		return $this;
	}
	
	/**
	 * String representation of widget
	 */
	public function __toString()
	{
		return $this->content;
	}
	
	public function init()
	{
		$this->_initTemplate();
	}
	
	/**
	 * @see WidgetInterface::render()
	 */
	public function render()
	{
		$this->_prepare();
		
		return $this->view->render($this->_template);
	}

	public function getTemplate()
	{
		return $this->_template;
	}
	
	/**
	 * Set template which must exist in view_manager['template_map'] array in module.config.php file
	 * 
	 * @param string $template
	 */
	public function setTemplate($template)
	{
		$this->_template = (string) $template;
	}
	
	/**
	 * Initialize template which should be exist in view_manager['template_map'] array in module.config.php file
	 * 
	 * @return void
	 */
	final protected function _initTemplate()
	{
		/**
		 * Get current widget's class name, something
		 * like "Catalog\Widget\Product\ProductWidget",
		 * and template file located at "Catalog/Widget/Product/template.phtml",
		 * and template aliase like "widget/product"
		 */
		$className = get_class($this);
		$location  = str_replace('\\', '/', $className);
		$parts 	   = explode('/Widget/', $location);
		$template  = strtolower(substr($parts[1], 0, strpos($parts[1], '/')));
		$template  = 'widget/' . $template;
		$this->_template = $template;
		
		/**************************************
		 * Get absolute widget template file
		 * 
		$className = get_class($this);
		$module    = substr($className, 0, strpos($className, '\\'));
		$location  = str_replace('\\', '/', $className);
		$location  = substr($location, 0, strrpos($location, '/'));
		$template  = MODULE_PATH . DS . $module . DS . 'src' . DS . $location . DS . 'template.phtml';
		$this->_template = $template;
		****************************************/
	}
	
}