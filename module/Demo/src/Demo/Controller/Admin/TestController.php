<?php

namespace Demo\Controller\Admin;

use ZendStore\Controller\AdminActionController;

class TestController extends AdminActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}
		
	public function viewAction()
	{
		$route = $controller = $this->getEvent()->getRouteMatch();
		$controller = $this->getEvent()->getRouteMatch()->getParam('controller');
		$action = $this->getEvent()->getRouteMatch()->getParam('action');
		echo $controller . '<br />';
		echo $action . '<br />';
		print_r($route); echo '<br />';
		
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}
}