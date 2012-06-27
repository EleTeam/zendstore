<?php

namespace Demo\Controller\Front;

use ZendStore\Controller\FrontActionController;

class TestController extends FrontActionController
{
	public function indexAction()
	{
		return new ViewModel(array(	
		));
	}
		
	public function viewAction()
	{
		
		$viewModel = $this->getViewModel();
		return $viewModel;
	}
}