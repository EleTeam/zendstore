<?php

namespace Media\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	Zend\File\Transfer,
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
// 			$ft = new FileTransfer('Http', true);
			$ft = new Transfer\Adapter\Http();
			$ft->setDestination(ROOT_PATH . '/data/upload/images')
			   ->addValidator('Size', false, array('max' => '512MB')) ;
			if (!$ft->receive()) {
				var_dump($ft->getMessages());				
			}
		}
		
		return array(
			'form' => $form,	
		);
	}
}