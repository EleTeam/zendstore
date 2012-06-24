<?php

namespace Demo\Controller\Admin;

use Base\Controller\BaseActionController;

class TestController extends BaseActionController
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