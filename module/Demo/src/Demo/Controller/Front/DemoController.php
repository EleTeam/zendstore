<?php

namespace Demo\Controller\Front;

use Base\Controller\Front\FrontActionController;

class DemoController extends FrontActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}	
}