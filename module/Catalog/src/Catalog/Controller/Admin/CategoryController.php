<?php

namespace Catalog\Controller\Admin;

use ZendStore\Controller\AdminActionController;

class CategoryController extends AdminActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel();
		
		return $viewModel;
	}	
}