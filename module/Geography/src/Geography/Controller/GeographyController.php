<?php

namespace Geography\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class GeographyController extends ActionController
{
	public function indexAction()
	{
		return new ViewModel();
	}
}