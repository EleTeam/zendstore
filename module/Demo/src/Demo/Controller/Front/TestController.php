<?php

namespace Demo\Controller\Front;

use Base\Controller\Front\FrontActionController;

class TestController extends FrontActionController
{
	public function indexAction()
	{
		return new ViewModel(array(	
		));
	}
		
	public function viewAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		return $viewModel;
	}
}