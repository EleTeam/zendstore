<?php

namespace Payment\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class PaymentController extends ActionController
{
	public function indexAction()
	{
		return new ViewModel();
	}
}