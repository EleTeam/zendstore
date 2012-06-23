<?php

namespace User\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	Zend\Authentication\AuthenticationService,
	Zend\Authentication\Adapter\DbTable as AuthenticationDbTable,
	Zend\Form\FormInterface,
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
    	$user = $this->getUserTable()->getUser(7);
        
    	$authService = new AuthenticationService();
    	echo 'User logined?';
        var_dump($authService->hasIdentity());
        var_dump($authService->getIdentity());

        return new ViewModel(array(
            'user' => $user,
        ));
    }
    
    public function registerAction()
    {
    	$authService = new AuthenticationService();
    	if ($authService->hasIdentity()) {
    		echo 'You have logined';
    		exit;
    	}
    	 
    	$request = $this->getRequest();
    	$form = new UserForm();
    	
    	if ($request->isPost()) {
    		$user = new User();
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->post());
    		
    		if ($form->isValid()) {
    			$formData = $form->getData();
    			$formData['password_salt'] 	= microtime(true);
    			$formData['password'] 		= md5($formData['password'] . $formData['password_salt']);
    			$formData['register_date']	= date('Y-m-d H:i:s');
    			$formData['active']			= 1;
    			
    			$user->populate($formData);
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
    
    public function loginAction()
    {
    	$authService = new AuthenticationService();
    	if ($authService->hasIdentity()) {
    		echo 'You have logined';
    		exit;
    	}
    	
    	$form = new UserForm();
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$user = new User();
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->post());
    		
    		if ($form->isValid()) {
    			$data = $form->getData();
    			// Authentication
    			$sm 		 = $this->getServiceLocator();
		    	$db			 = $sm->get('db-adapter');
		    	//$authDbTable = new AuthenticationDbTable($db, 'user', 'email', 'password', 'MD5(?)');
		    	$authDbTable = new AuthenticationDbTable($db, 'user', 'email', 'password', 'MD5(CONCAT(?, password_salt))');
		    	$authDbTable->setIdentity($data['email']);
		    	$authDbTable->setCredential($data['password']);
		    	$result 	 = $authService->authenticate($authDbTable);
		    	if ($result->isValid()) {
		    		return $this->redirect()->toRoute('user');
		    	} else {
		    		var_dump($result->getMessages());
		    	}
    		} else {
    			echo '<h1>ERROR: Form data is invalid.</h1>';
    			echo '<pre>';
    			print_r($form->getMessages());
    			exit;
    		}
    	}
    	
    	return array('form' => $form);
    }
    
    public function logoutAction()
    {
    	$authService = new AuthenticationService();
    	$authService->clearIdentity();
    	return $this->redirect()->toRoute('user');
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
