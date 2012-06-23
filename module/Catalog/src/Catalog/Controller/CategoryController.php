<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class CategoryController extends ActionController
{
	public function indexAction()
	{
		return new ViewModel(array(	
		));
	}	
}