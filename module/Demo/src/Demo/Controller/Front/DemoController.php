<?php

namespace Demo\Controller\Front;

use ZendStore\Controller\AbstractFrontActionController;

class DemoController extends AbstractFrontActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel();
		
		return $viewModel;
	}	

	/**
	 * To disable the view completely, from within a controller action,
	 * you should return a Response object
	 */
	public function disableViewAction()
	{
		$response = $this->getResponse();
		//$response->setStatusCode(200);
		$response->setContent("Hello world");
		return $response;
	}
}