<?php

namespace User\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	User\Form\UserForm;

class UserController extends ActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'v' => 'value',
        ));
    }
    
    public function loginAction()
    {
    	
    }
    
    public function registerAction()
    {
    	$form = new UserForm();
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		
    	}
    	
    	return array('form' => $form);
    }
}
