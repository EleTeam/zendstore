<?php

namespace Base\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class BaseController extends ActionController
{
	
	public function indexAction()
	{
		return new ViewModel();
	}
}