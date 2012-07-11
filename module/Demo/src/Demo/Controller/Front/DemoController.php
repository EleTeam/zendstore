<?php

namespace Demo\Controller\Front;

use Zend\View\Helper\ViewModel;

use ZendStore\Controller\AbstractFrontActionController;

class DemoController extends AbstractFrontActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel();
		
		return $viewModel;
	}	

	/**
	 * To disable layout, just return ViewModel with $viewModel->setTerminal(true); 
	 */
	public function disableLayoutAction()
	{
		$viewModel = $this->getViewModel();
		$viewModel->setTerminal(true);
		return $viewModel;
	}
	
	/**
	 * To disable the view, just return empty string
	 */
	public function disableViewAction()
	{
		$viewModel = $this->getViewModel();
		return '';
	}
	
	/**
	 * To disable the template(layout and view) completely, from within a controller action,
	 * you should return a Response object
	 */
	public function disableTemplateAction()
	{
		$response = $this->getResponse();
		//$response->setStatusCode(200);
		$response->setContent("Hello world");
		return $response;
	}
}