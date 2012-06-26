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
	protected $template;
	
	/**
	 * Prepare variables for view template
	 */
	abstract protected function _prepare();
	
	public function __construct()
	{
		$this->init();
	}
	
	public function init()
	{
		$this->_initTemplate();
	}
	
	/**
	 * @see WidgetInterface::display()
	 */
	public function display()
	{
		$content = '<p>Default widget content</p>';
		
// 		$this->view->render('/home/huangzhihua/www/website/zendstore/module/Catalog/src/Catalog/Widget/Product/template.phtml');
// 		$this->view->render(new ViewModel(array('template' => '/home/huangzhihua/www/website/zendstore/module/Catalog/src/Catalog/Widget/Product/template.phtml')), array('template' => '/home/huangzhihua/www/website/zendstore/module/Catalog/src/Catalog/Widget/Product/template.phtml'));
		return $content;
	}

	public function getTemplate()
	{
		return $this->template;
	}
	
	public function setTemplate($template)
	{
		$this->template = (string) $template;
	}
	
	final protected function _initTemplate()
	{
		$className = get_class($this);
		$module    = substr($className, 0, strpos($className, '\\'));
		$location  = str_replace('\\', '/', $className);
		$location  = substr($location, 0, strrpos($location, '/'));
		$template  = MODULE_PATH . DS . $module . DS . 'src' . DS . $location . DS . 'template.phtml';
		$this->template = $template;
	}
	
}