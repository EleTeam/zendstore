<?php

namespace Demo\Controller\Front;

use Zend\Mvc\Controller\ActionController,
	Base\Controller\BaseActionController;

class DemoController extends BaseActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}	
}