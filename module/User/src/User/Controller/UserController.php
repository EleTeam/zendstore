<?php

namespace User\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	User\Model\UserTable,
	User\Model\User,
	User\Form\UserForm;

class UserController extends ActionController
{
	/**
	 * @var UserTable
	 */
	protected $userTable;
	
    public function indexAction()
    {
    	$user = $this->getUserTable()->getUser(1);
        
        return new ViewModel(array(
            'user' => $user,
        ));
    }
    
    public function loginAction()
    {
    	$form = new UserForm();
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		return $this->redirect()->toRoute('user');
    	}
    	
    	return array('form' => $form);
    }
    
    public function registerAction()
    {
    	$form = new UserForm();
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$user = new User();
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->post());
    		if ($form->isValid()) {
    			$user->populate($form->getData());
    			$this->getUserTable()->saveUser($user);
    			return $this->redirect()->toRoute('user', array('action' => 'login'));
    		} else {
    			echo '<pre>';
    			print_r($form->getMessages());
    			exit;
    		}
    	}
    	
    	return array('form' => $form);
    }
    
    /**
     * Get an instance of UserTable
     * 
     * @return UserTable
     */
    public function getUserTable()
    {
    	if (!$this->userTable) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('user-table');
    	}	
    	return $this->userTable;
    }
    
}
