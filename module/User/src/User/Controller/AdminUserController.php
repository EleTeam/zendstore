<?php

namespace User\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class AdminUserController extends ActionController
{
	public function indexAction()
	{
		return new ViewModel();
	}
    
}
