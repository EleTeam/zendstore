<?php

namespace User\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class UserController extends ActionController
{
	public function indexAction()
	{
		exit('ok');
		$message = $this->getRequest()->query()->get('message', 'Message Here');
		return array('message' => $message);
		//$this->flashMessenger()->addMessage('You are now logged in.');
		//return $this->redirect()->toRoute('hello/test');
	}
    
    public function testAction()
    {
    	$name = $this->getRequest()->query()->get('name', 'huazai');
//     	$flashMessenger = $this->flashMessenger();
//     	if ($flashMessenger->hasMessages()) {
//     		$return['messages'] = $flashMessenger->getMessages();
//     	}
    	$return['name'] = $name;
    	//return $return;
    	return new ViewModel(array('name' => $name));
    }
}
