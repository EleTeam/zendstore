<?php

namespace Demo\Controller\Admin;

use Zend\Mvc\Controller\ActionController,
	Base\Controller\BaseActionController;

class DemoController extends BaseActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}	
	
	public function viewAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;		
	}
}
