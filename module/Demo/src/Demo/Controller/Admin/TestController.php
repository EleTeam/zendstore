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
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}
}