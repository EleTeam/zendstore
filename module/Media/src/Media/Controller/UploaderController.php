<?php

namespace Media\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	Media\Form\UploaderForm;

class UploaderController extends ActionController
{
	
	public function indexAction()
	{
		return new ViewModel();
	}
	
	public function uploadAction()
	{
		$request = $this->getRequest();
		$form = new UploaderForm();
		
		if ($request->isPost()) {
			
		}
		
		return array(
			'form' => $form,	
		);
	}
}