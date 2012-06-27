<?php

namespace Catalog\Controller\Front;

use ZendStore\Controller\FrontActionController;

class CategoryController extends FrontActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel();
		
		return $viewModel;
	}	
}