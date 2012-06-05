<?php

namespace Media\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class SwfuploadController extends ActionController
{
	
	public function indexAction()
	{
		return new ViewModel();
	}
	
}