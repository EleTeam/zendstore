<?php

namespace Catalog\Controller\Front;

use Base\Controller\Front\FrontActionController;

class CategoryController extends FrontActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}	
}