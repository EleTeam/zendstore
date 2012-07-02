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
	
	public function addAction()
	{
		return $this->forward()->dispatch('catalog-admin-category', array(
			'action' => 'edit',
			'forwardedRouteName' => 'catalog-admin-category'));		
	}
	
	public function editAction()
	{
		$viewModel = $this->getViewModel();
		
		return $viewModel;		
	}
}