<?php

namespace Demo\Controller\Front;

use Base\Controller\Front\Front\ActionController;

class DemoController extends FrontActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}	
}