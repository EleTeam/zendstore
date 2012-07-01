<?php

namespace Catalog\Controller\Admin;

use ZendStore\Controller\AbstractAdminActionController;

class CategoryController extends AbstractAdminActionController
{
	public function indexAction()
	{
		$viewModel = $this->getViewModel();
		
		return $viewModel;
	}	
}