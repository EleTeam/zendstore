<?php

namespace ZendStore\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use	Zend\View\Model\ViewModel;

/**
 * ZendStore abstract action controller,
 * every controller should extends it.
 */
abstract class AbstractStoreActionController extends AbstractActionController
{
	/**
	 * Default layout template
	 * 
	 * @var string
	 */
	protected $layout = 'layout/layout';
	
// 	public function __construct()
// 	{
// 		$this->init();
// 	}
	
// 	/**
// 	 * Initialization
// 	 */
// 	public function init()
// 	{
//  		$this->layout()->setTemplate($this->layout);
// 	}
	
// 	/**
// 	 * Get layout template
// 	 * 
// 	 * @return string
// 	 */
// 	public function getLayout()
// 	{
// 		return $this->layout;
// 	}
	
// 	/**
// 	 * Set layout template which may be an alias etc. "layout/layout"
// 	 * 
// 	 * @param string $layout
// 	 * @return Self $this
// 	 */
// 	public function setLayout($layout)
// 	{
// 		$this->layout = $layout;
// 		return $this;
// 	}
	
	/**
	 * Get ViewModel, should be invoked in controller's action function
	 * 
	 * If ViewModel hasn't defined template yet, set ZendStore default template for the ViewModel
	 * 
	 * @return ViewModel
	 */	
	public function getViewModel()
	{
		/* Set default template
		 * Build template such as "demo/front/test/view" for viewModel,
		 * controller should be as "/front/demo/test", action as "view"
		 */
		$controller = $this->getEvent()->getRouteMatch()->getParam('controller');
		$action     = $this->getEvent()->getRouteMatch()->getParam('action');
		$route		= $this->getEvent()->getRouteMatch()->getMatchedRouteName();
		$template   = str_replace('-', '/', $route) . '/' . $action;

		// Set layout
		$this->layout()->setTemplate($this->layout);
		$this->layout()->setVariable('route', $route);

		// Set ViewModel
		$viewModel = new ViewModel();
		$viewModel->setTemplate($template);
		$viewModel->setVariable('route', $route);
		
		return $viewModel;
	}
}
