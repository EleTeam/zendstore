<?php

namespace Demo\Controller\Front;

use ZendStore\Controller\FrontActionController;

class DemoController extends FrontActionController
{
	public function indexAction()
	{
		$route = $this->getEvent()->getRouteMatch();
		$controller = $this->getEvent()->getRouteMatch()->getParam('controller');
		$action = $this->getEvent()->getRouteMatch()->getParam('action');
		echo $controller . '<br />';
		echo $action . '<br />';
		print_r($route); echo '<br />';
		
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}	
}