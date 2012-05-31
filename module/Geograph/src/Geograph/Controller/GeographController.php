<?php

namespace Geograph\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class GeographController extends ActionController
{
	public function indexAction()
	{
		return new ViewModel();
	}
}