<?php

namespace ZendStore\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

/**
 * ZendStore admin platform based action controller
 */
abstract class AdminActionController extends ActionController
{
	const VIEW_LAYOUT = 'layout/admin';
	
	public function __construct()
	{
		$this->init();
	}
	
	/**
	 * Initialization for controllers which extend this controller
	 */
	public function init()
	{
		$this->layout()->setTemplate(self::VIEW_LAYOUT);
	}
	
	/**
	 * Get ViewModel
	 * 
	 * If $__METHOD__ was given, set template for the ViewModel
	 * 
	 * @param string $__METHOD__ Controller's action magic method 
	 * @return ViewModel
	 */	
	public function getViewModel($__METHOD__ = null)
	{
		$viewModel = new ViewModel();
		
		// Set template for ViewModel
		if ($__METHOD__) {
			/* Use substr() instead of rtrim() which has a bug in PHP Version 5.3.8-ZS5.5.0
			 *	<code>
			*		rtrim('TestttCon', 'Con')   == "Testtt"		// Valid
			*		rtrim('TestttCont', 'Cont') == "Tes"		// Invalid
			*		substr('TestttCont', 0, strlen('TestttCont') - strlen('Cont')) == "Testtt" // Valid
			* 	</code>
			*/
			// $template = rtrim(__CLASS__, 'Controller');
			// $template = substr(__CLASS__, 0, strlen(__CLASS__) - strlen('Controller'));
			
			// Change "Demo\Controller\Front\TestController::viewAction" to "demo/front/test/view"
			$template = str_replace('\\', '/', $__METHOD__);
			$template = str_replace(array('/Controller/', 'Controller::'), array('/', '/'), $template);
			$template = substr($template, 0, strlen($template) - strlen('Action'));
			$template = strtolower($template);

			$viewModel->setTemplate($template);
		}
		
		return $viewModel;
	}
}