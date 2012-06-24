<?php

namespace Catalog\Controller\Front;

use Base\Controller\BaseActionController;

class CategoryController extends BaseActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
	}	
}